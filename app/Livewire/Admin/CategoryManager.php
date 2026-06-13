<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.admin')]
class CategoryManager extends Component
{
    public bool $showModal = false;
    public ?int $editId = null;

    public string $name = '';

    public string $slug = '';
    public ?string $parentId = null;
    public bool $status = true;

    public function render()
    {
        $categories = Category::with('parent', 'children')
            ->orderBy('name')
            ->get()
            ->groupBy(fn ($c) => $c->parent_id === null ? 'parent' : 'child');

        return view('livewire.admin.category-manager', [
            'parents'         => $categories->get('parent', collect()),
            'children'        => $categories->get('child', collect()),
            'categoryOptions' => Category::parents()->active()->orderBy('name')->get(),
        ]);
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEdit(Category $category): void
    {
        $this->resetForm();
        $this->editId     = $category->id;
        $this->name       = $category->name;
        $this->slug       = $category->slug;
        $this->parentId   = $category->parent_id ? (string) $category->parent_id : null;
        $this->status     = $category->status;
        $this->showModal  = true;
    }

    public function save(): void
    {
        $this->slug = $this->slug ?: Str::slug($this->name);

        $rules = [
            'name' => 'required|min:2|max:255',
        ];

        if ($this->editId) {
            $rules['slug'] = 'required|unique:categories,slug,' . $this->editId;
        } else {
            $rules['slug'] = 'required|unique:categories,slug';
        }

        $this->validate($rules);

        $data = [
            'name'      => $this->name,
            'slug'      => $this->slug,
            'parent_id' => $this->parentId ?: null,
            'status'    => $this->status,
        ];

        $isEdit = (bool) $this->editId;

        try {
            if ($isEdit) {
                Category::findOrFail($this->editId)->update($data);
            } else {
                Category::create($data);
            }
        } catch (\Throwable $e) {
            $this->dispatch('show-toast', message: 'Terjadi kesalahan saat menyimpan kategori.', type: 'error');
            return;
        }

        $this->showModal = false;
        $this->resetForm();
        AdminLog::log(
            $isEdit ? 'update_category' : 'create_category',
            "Kategori: {$this->name}"
        );
        $this->dispatch('show-toast',
            message: $isEdit ? 'Kategori berhasil diperbarui.' : 'Kategori berhasil ditambahkan.',
            type: 'success'
        );
    }

    public function delete(Category $category): void
    {
        $name = $category->name;
        try {
            $category->delete();
        } catch (Throwable $e) {
            $this->dispatch('show-toast', message: 'Gagal menghapus kategori.', type: 'error');
            return;
        }
        AdminLog::log('delete_category', "Kategori: {$name}");
        $this->dispatch('show-toast', message: 'Kategori berhasil dihapus.', type: 'success');
    }

    public function resetForm(): void
    {
        $this->editId   = null;
        $this->name     = '';
        $this->slug     = '';
        $this->parentId = null;
        $this->status   = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }
}
