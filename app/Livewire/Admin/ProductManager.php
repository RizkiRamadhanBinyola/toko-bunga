<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

#[Layout('layouts.admin')]
class ProductManager extends Component
{
    use WithFileUploads;

    public string $search = '';
    public bool $showModal = false;
    public ?int $editId = null;

    public string $name = '';
    public string $slug = '';
    public string $categoryId = '';
    public string $price = '';
    public string $description = '';
    public bool $status = true;

    public array $images = [];
    public array $existingImages = [];

    public array $variants = [];
    public ?bool $slugAvailable = null;

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

        $product = Product::with(['variants', 'images'])->findOrFail($id);
        $this->editId = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->categoryId = (string) $product->category_id;
        $this->price = (string) $product->price;
        $this->description = $product->description ?? '';
        $this->status = $product->status;

        $dbImages = $product->images->pluck('image_url')->toArray();

        $allVariantPaths = collect();
        foreach ($product->variants as $v) {
            if ($v->image) {
                $allVariantPaths->push($v->image);
            }
            foreach ($v->extra_images ?? [] as $p) {
                $allVariantPaths->push($p);
            }
        }

        $this->existingImages = array_values(array_diff($dbImages, $allVariantPaths->toArray()));

        $this->variants = $product->variants->map(fn (ProductVariant $v) => [
            'id'              => $v->id,
            'name'            => $v->name ?? '',
            'images'          => [],
            'existingImages'  => array_values(array_unique(array_filter([
                $v->image,
                ...($v->extra_images ?? []),
            ]))),
            'description'     => $v->description ?? '',
            'price'           => $v->price !== null ? (string) $v->price : '',
            'sort_order'      => $v->sort_order,
            'status'          => $v->status,
        ])->values()->toArray();

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    // ── Image helpers ─────────────────────────────────────────────

    public function removeImage(int $index): void
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeExistingImage(int $index): void
    {
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);
    }

    public function removeVariantImage(int $variantIndex, int $imageIndex): void
    {
        unset($this->variants[$variantIndex]['images'][$imageIndex]);
        $this->variants[$variantIndex]['images'] = array_values($this->variants[$variantIndex]['images']);
    }

    public function removeVariantExistingImage(int $variantIndex, int $imageIndex): void
    {
        unset($this->variants[$variantIndex]['existingImages'][$imageIndex]);
        $this->variants[$variantIndex]['existingImages'] = array_values($this->variants[$variantIndex]['existingImages']);
    }

    // ── Variant helpers ───────────────────────────────────────────

    public function addVariant(): void
    {
        $this->variants[] = [
            'id'              => null,
            'name'            => '',
            'images'          => [],
            'existingImages'  => [],
            'description'     => '',
            'price'           => '',
            'sort_order'      => count($this->variants),
            'status'          => true,
        ];
    }

    public function removeVariant(int $index): void
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    // ── Save ──────────────────────────────────────────────────────

    public function save(): void
    {
        $this->slug = $this->slug ?: Str::slug($this->name);

        $slugRule = 'required|unique:products,slug';
        if ($this->editId) {
            $slugRule .= ',' . $this->editId;
        }

        $this->validate([
            'name'                   => 'required|min:2|max:255',
            'slug'                   => $slugRule,
            'categoryId'             => 'required|exists:categories,id',
            'price'                  => 'required|numeric|min:0',
            'images'                 => 'nullable|array|max:3',
            'images.*'               => 'image|mimes:jpeg,png,webp|max:2048',
            'variants.*.images'      => 'nullable|array|max:3',
            'variants.*.images.*'    => 'image|mimes:jpeg,png,webp|max:2048',
            'variants.*.price'       => 'nullable|numeric|min:0',
        ], [
            'name.required'                => 'Nama produk wajib diisi.',
            'categoryId.required'          => 'Kategori wajib dipilih.',
            'price.required'               => 'Harga dasar wajib diisi.',
            'price.numeric'                => 'Harga harus berupa angka.',
            'images.*.image'               => 'File harus berupa gambar.',
            'images.*.mimes'               => 'Gambar harus bertipe: jpeg, png, webp.',
            'images.*.max'                 => 'Gambar maksimal 2MB.',
            'variants.*.images.*.image'    => 'Gambar varian harus berupa gambar.',
            'variants.*.images.*.mimes'    => 'Gambar varian harus bertipe: jpeg, png, webp.',
            'variants.*.images.*.max'      => 'Gambar varian maksimal 2MB.',
            'variants.*.price.numeric'     => 'Harga varian harus berupa angka.',
        ]);

        if (count($this->images) + count($this->existingImages) > 3) {
            $this->addError('images', 'Foto produk maksimal 3.');
            return;
        }

        foreach ($this->variants as $i => $v) {
            if (count($v['images']) + count($v['existingImages']) > 3) {
                $this->addError("variants.{$i}.images", 'Foto varian maksimal 3.');
                return;
            }
        }

        // ── Handle product images ─────────────────────────────────
        $imagePaths = $this->existingImages;

        if ($this->editId) {
            $oldProduct = Product::with('images')->find($this->editId);
            if ($oldProduct) {
                $oldPaths = $oldProduct->images->pluck('image_url')->toArray();
                $removed = array_diff($oldPaths, $this->existingImages);
                foreach ($removed as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        foreach ($this->images as $img) {
            if ($img) {
                $imagePaths[] = $img->store('products', 'public');
            }
        }

        // ── Product data ──────────────────────────────────────────
        $data = [
            'name'        => $this->name,
            'slug'        => $this->slug,
            'category_id' => $this->categoryId,
            'price'       => $this->price,
            'description' => $this->description,
            'status'      => $this->status,
            'thumbnail'   => $imagePaths[0] ?? null,
        ];

        try {
            if ($this->editId) {
                $product = Product::findOrFail($this->editId);
                $product->update($data);
            } else {
                $product = Product::create($data);
            }
        } catch (Throwable $e) {
            $this->showToast('Terjadi kesalahan saat menyimpan produk.', 'error');
            return;
        }

        // ── Sync product_images table ─────────────────────────────
        $product->images()->delete();
        foreach ($imagePaths as $path) {
            $product->images()->create(['image_url' => $path]);
        }

        // ── Sync variants ─────────────────────────────────────────
        $keptIds = [];

        // Collect old variant image paths for cleanup
        $oldVariantPaths = [];
        if ($this->editId) {
            $oldVariants = ProductVariant::where('product_id', $this->editId)->get();
            foreach ($oldVariants as $ov) {
                if ($ov->image) $oldVariantPaths[$ov->id][] = $ov->image;
                foreach ($ov->extra_images ?? [] as $p) {
                    $oldVariantPaths[$ov->id][] = $p;
                }
            }
        }

        foreach ($this->variants as $index => $v) {
            $allVariantImages = [];
            foreach ($v['images'] as $img) {
                if ($img) {
                    $allVariantImages[] = $img->store('variants', 'public');
                }
            }
            $allVariantImages = array_merge($allVariantImages, $v['existingImages']);

            $variantData = [
                'name'         => $v['name'] ?: null,
                'description'  => $v['description'] ?: null,
                'price'        => $v['price'] !== '' ? $v['price'] : null,
                'sort_order'   => $index,
                'image'        => $allVariantImages[0] ?? null,
                'extra_images' => array_values(array_slice($allVariantImages, 1)),
                'status'       => $v['status'] ?? true,
            ];

            if (! empty($v['id'])) {
                $variant = ProductVariant::find($v['id']);
                if ($variant) {
                    // Delete old variant images that were removed
                    $oldForThis = $oldVariantPaths[$variant->id] ?? [];
                    $newForThis = array_filter($allVariantImages);
                    $removed = array_diff($oldForThis, $newForThis);
                    foreach ($removed as $path) {
                        Storage::disk('public')->delete($path);
                    }

                    $variant->update($variantData);
                    $keptIds[] = $variant->id;
                }
            } else {
                $variant = $product->variants()->create($variantData);
                $keptIds[] = $variant->id;
            }
        }

        // Delete removed variants and their images
        $product->variants()
            ->whereNotIn('id', $keptIds)
            ->each(function (ProductVariant $v) {
                if ($v->image) {
                    Storage::disk('public')->delete($v->image);
                }
                foreach ($v->extra_images ?? [] as $path) {
                    Storage::disk('public')->delete($path);
                }
                $v->delete();
            });

        // Clean up product_images table: remove any records that are variant images
        $product->images()
            ->where('image_url', 'like', 'variants/%')
            ->each(fn (ProductImage $pi) => $pi->delete());

        $this->showModal = false;
        $isEdit = (bool) $this->editId;
        AdminLog::log(
            $isEdit ? 'update_product' : 'create_product',
            "Produk: {$this->name}"
        );
        $this->resetForm();
        $this->showToast($isEdit ? 'Produk berhasil diperbarui.' : 'Produk berhasil ditambahkan.');
    }

    // ── Delete ────────────────────────────────────────────────────

    public function delete(int $id): void
    {
        $product = Product::with(['variants', 'images'])->findOrFail($id);
        $name = $product->name;

        try {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->image_url);
            }
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            foreach ($product->variants as $v) {
                if ($v->image) {
                    Storage::disk('public')->delete($v->image);
                }
                foreach ($v->extra_images ?? [] as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            $product->delete();
        } catch (Throwable $e) {
            $this->showToast('Gagal menghapus produk.', 'error');
            return;
        }

        AdminLog::log('delete_product', "Produk: {$name}");
        $this->showToast('Produk berhasil dihapus.', 'success');
    }

    // ── Helpers ───────────────────────────────────────────────────

    public function generateSlug(): void
    {
        if (! $this->slug) {
            $this->slug = Str::slug($this->name);
        }
    }

    protected function checkSlug(): void
    {
        $slug = $this->slug ?: Str::slug($this->name);

        if (! $slug) {
            $this->slugAvailable = null;
            return;
        }

        $query = Product::where('slug', $slug);
        if ($this->editId) {
            $query->where('id', '!=', $this->editId);
        }

        $this->slugAvailable = ! $query->exists();
    }

    public function updatedName(): void
    {
        if (! $this->slug) {
            $this->slug = Str::slug($this->name);
        }
        $this->checkSlug();
    }

    public function updatedSlug(): void
    {
        $this->slug = Str::slug($this->slug);
        $this->checkSlug();
    }

    public function showToast(string $message, string $type = 'success'): void
    {
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
        $this->images = [];
        $this->existingImages = [];
        $this->variants = [];
        $this->slugAvailable = null;
    }
}
