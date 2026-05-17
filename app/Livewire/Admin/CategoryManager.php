<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class CategoryManager extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public ?int $editId = null;

    #[Validate('required|min:2|max:255')]
    public string $name = '';

    public string $slug = '';
    public ?string $parentId = null;
    public $thumbnail = null;
    public bool $status = true;
    public ?string $existingThumbnail = null;

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
        $this->editId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->parentId = $category->parent_id ? (string) $category->parent_id : null;
        $this->status = $category->status;
        $this->existingThumbnail = $category->thumbnail;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name'      => $this->name,
            'slug'      => $this->slug ?: Str::slug($this->name),
            'parent_id' => $this->parentId ?: null,
            'status'    => $this->status,
        ];

        if ($this->thumbnail) {
            if ($this->existingThumbnail) {
                Storage::disk('public')->delete($this->existingThumbnail);
            }
            $data['thumbnail'] = $this->thumbnail->store('categories', 'public');
        }

        $isEdit = (bool) $this->editId;

        if ($isEdit) {
            Category::findOrFail($this->editId)->update($data);
        } else {
            Category::create($data);
        }

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('show-toast',
            message: $isEdit ? 'Kategori berhasil diperbarui.' : 'Kategori berhasil ditambahkan.',
            type: 'success'
        );
    }

    public function delete(Category $category): void
    {
        if ($category->thumbnail) {
            Storage::disk('public')->delete($category->thumbnail);
        }
        $category->delete();
        $this->dispatch('show-toast', message: 'Kategori berhasil dihapus.', type: 'success');
    }

    public function resetForm(): void
    {
        $this->editId = null;
        $this->name = '';
        $this->slug = '';
        $this->parentId = null;
        $this->thumbnail = null;
        $this->status = true;
        $this->existingThumbnail = null;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function generateSlug(): void
    {
        $this->slug = Str::slug($this->name);
    }
}
