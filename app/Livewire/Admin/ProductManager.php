<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class ProductManager extends Component
{
    use WithFileUploads;

    // ── List state ────────────────────────────────────────────────
    public string $search = '';

    // ── Modal state ───────────────────────────────────────────────
    public bool $showModal = false;
    public ?int $editId = null;

    // ── Product fields ────────────────────────────────────────────
    public string $name = '';
    public string $slug = '';
    public string $categoryId = '';
    public string $price = '';
    public string $description = '';
    public bool $status = true;
    public $thumbnail = null;
    public ?string $existingThumbnail = null;

    // ── Variants ──────────────────────────────────────────────────
    // Each item: ['id' => null|int, 'image' => null, 'existingImage' => null, 'description' => '', 'price' => '', 'sort_order' => 0]
    public array $variants = [];

    // ── Toast ─────────────────────────────────────────────────────
    public ?string $toastMessage = null;
    public string $toastType = 'success'; // success | error

    public function render()
    {
        $query = Product::with(['category', 'variants']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('slug', 'like', "%{$this->search}%");
            });
        }

        return view('livewire.admin.product-manager', [
            'products' => $query->latest()->paginate(10),
            'categories' => Category::with('children')->parents()->active()->orderBy('name')->get(),
        ]);
    }

    // ── Open / Close ──────────────────────────────────────────────

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();

        $product = Product::with('variants')->findOrFail($id);
        $this->editId = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->categoryId = (string) $product->category_id;
        $this->price = (string) $product->price;
        $this->description = $product->description ?? '';
        $this->status = $product->status;
        $this->existingThumbnail = $product->thumbnail;

        $this->variants = $product->variants->map(fn (ProductVariant $v) => [
            'id'            => $v->id,
            'name'          => $v->name ?? '',
            'image'         => null,
            'existingImage' => $v->image,
            'description'   => $v->description ?? '',
            'price'         => $v->price !== null ? (string) $v->price : '',
            'sort_order'    => $v->sort_order,
        ])->values()->toArray();

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    // ── Variant helpers ───────────────────────────────────────────

    public function addVariant(): void
    {
        $this->variants[] = [
            'id'            => null,
            'name'          => '',
            'image'         => null,
            'existingImage' => null,
            'description'   => '',
            'price'         => '',
            'sort_order'    => count($this->variants),
        ];
    }

    public function removeVariant(int $index): void
    {
        // If existing variant, delete from DB immediately on save — just mark for removal
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    // ── Save ──────────────────────────────────────────────────────

    public function save(): void
    {
        $this->validate([
            'name'       => 'required|min:2|max:255',
            'categoryId' => 'required|exists:categories,id',
            'price'      => 'required|numeric|min:0',
            'variants.*.price' => 'nullable|numeric|min:0',
        ], [
            'name.required'       => 'Nama produk wajib diisi.',
            'categoryId.required' => 'Kategori wajib dipilih.',
            'price.required'      => 'Harga dasar wajib diisi.',
            'price.numeric'       => 'Harga harus berupa angka.',
            'variants.*.price.numeric' => 'Harga varian harus berupa angka.',
        ]);

        // ── Product data ──────────────────────────────────────────
        $data = [
            'name'        => $this->name,
            'slug'        => $this->slug ?: Str::slug($this->name),
            'category_id' => $this->categoryId,
            'price'       => $this->price,
            'description' => $this->description,
            'status'      => $this->status,
        ];

        if ($this->thumbnail) {
            // Delete old thumbnail
            if ($this->existingThumbnail) {
                Storage::disk('public')->delete($this->existingThumbnail);
            }
            $data['thumbnail'] = $this->thumbnail->store('products', 'public');
        } elseif ($this->existingThumbnail === null && $this->editId) {
            // Thumbnail was cleared
            $product = Product::find($this->editId);
            if ($product?->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = null;
        }

        if ($this->editId) {
            $product = Product::findOrFail($this->editId);
            $product->update($data);
        } else {
            $product = Product::create($data);
        }

        // ── Sync variants ─────────────────────────────────────────
        $keptIds = [];

        foreach ($this->variants as $index => $v) {
            $variantData = [
                'name'        => $v['name'] ?: null,
                'description' => $v['description'] ?: null,
                'price'       => $v['price'] !== '' ? $v['price'] : null,
                'sort_order'  => $index,
            ];

            // Handle image upload for this variant
            if (! empty($v['image'])) {
                // Delete old image if replacing
                if (! empty($v['existingImage'])) {
                    Storage::disk('public')->delete($v['existingImage']);
                }
                $variantData['image'] = $v['image']->store('variants', 'public');
            } elseif (! empty($v['existingImage'])) {
                $variantData['image'] = $v['existingImage'];
            } else {
                $variantData['image'] = null;
            }

            if (! empty($v['id'])) {
                // Update existing
                $variant = ProductVariant::find($v['id']);
                if ($variant) {
                    $variant->update($variantData);
                    $keptIds[] = $variant->id;
                }
            } else {
                // Create new
                $variant = $product->variants()->create($variantData);
                $keptIds[] = $variant->id;
            }
        }

        // Delete variants that were removed
        $product->variants()
            ->whereNotIn('id', $keptIds)
            ->each(function (ProductVariant $v) {
                if ($v->image) {
                    Storage::disk('public')->delete($v->image);
                }
                $v->delete();
            });

        $this->showModal = false;
        $isEdit = (bool) $this->editId;
        $this->resetForm();
        $this->showToast($isEdit ? 'Produk berhasil diperbarui.' : 'Produk berhasil ditambahkan.');
    }

    // ── Delete ────────────────────────────────────────────────────

    public function delete(int $id): void
    {
        $product = Product::with('variants')->findOrFail($id);

        // Clean up files
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        foreach ($product->variants as $v) {
            if ($v->image) {
                Storage::disk('public')->delete($v->image);
            }
        }

        $product->delete();
        $this->showToast('Produk berhasil dihapus.', 'success');
    }

    // ── Helpers ───────────────────────────────────────────────────

    public function generateSlug(): void
    {
        if (! $this->slug) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function showToast(string $message, string $type = 'success'): void
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->dispatch('show-toast', message: $message, type: $type);
    }

    public function resetForm(): void
    {
        $this->editId = null;
        $this->name = '';
        $this->slug = '';
        $this->categoryId = '';
        $this->price = '';
        $this->description = '';
        $this->status = true;
        $this->thumbnail = null;
        $this->existingThumbnail = null;
        $this->variants = [];
    }
}
