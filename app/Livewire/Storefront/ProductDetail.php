<?php

namespace App\Livewire\Storefront;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.storefront')]
class ProductDetail extends Component
{
    public Product $product;

    // null  = tidak ada varian dipilih (tampil data dasar produk)
    // int   = id varian yang dipilih
    public ?int $selectedVariantId = null;

    // Order form
    public string $customerName    = '';
    public string $recipientName   = '';
    public string $deliveryAddress = '';
    public string $deliveryDate    = '';
    public string $greetingMessage = '';
    public string $notes           = '';

    public function mount(string $slug): void
    {
        $this->product = Product::where('slug', $slug)
            ->active()
            ->with(['category', 'variants'])
            ->firstOrFail();

        // Tidak pre-select varian — tampilkan data dasar dulu
        // User harus klik varian untuk melihat detail varian
        $this->selectedVariantId = null;
    }

    /**
     * Toggle varian: klik varian aktif → deselect (kembali ke data dasar)
     * klik varian lain → pilih varian tersebut
     */
    public function selectVariant(int $id): void
    {
        if ($this->selectedVariantId === $id) {
            $this->selectedVariantId = null;
        } else {
            $this->selectedVariantId = $id;
        }

        // Beritahu Alpine carousel untuk pindah ke slide yang sesuai
        $this->dispatch('variant-changed', variantId: $this->selectedVariantId);
    }

    /**
     * Varian yang sedang dipilih, atau null.
     */
    public function getSelectedVariantProperty(): ?ProductVariant
    {
        if (! $this->selectedVariantId) {
            return null;
        }

        return $this->product->variants->firstWhere('id', $this->selectedVariantId);
    }

    /**
     * Harga yang ditampilkan:
     * - Ada varian dipilih → harga varian (fallback harga dasar)
     * - Tidak ada varian   → harga dasar produk
     */
    public function getActivePriceProperty(): ?string
    {
        $v = $this->selected_variant;
        if ($v) {
            return ($v->price !== null && $v->price != '') ? (string) $v->price : (string) $this->product->price;
        }

        return $this->product->price ? (string) $this->product->price : null;
    }

    /**
     * Deskripsi yang ditampilkan:
     * - Ada varian dipilih → deskripsi varian (fallback deskripsi dasar)
     * - Tidak ada varian   → deskripsi dasar produk
     */
    public function getActiveDescriptionProperty(): ?string
    {
        $v = $this->selected_variant;
        if ($v) {
            return ($v->description !== null && $v->description !== '')
                ? $v->description
                : $this->product->description;
        }

        return $this->product->description;
    }

    /**
     * Semua slide carousel.
     */
    public function getCarouselImagesProperty(): array
    {
        $images = [];

        if ($this->product->variants->isNotEmpty()) {
            foreach ($this->product->variants as $v) {
                $images[] = [
                    'variantId' => $v->id,
                    'image'     => $v->image ?: $this->product->thumbnail,
                ];
            }

            // Prepend thumbnail produk jika belum ada di slide pertama
            if ($this->product->thumbnail) {
                $firstImage = $images[0]['image'] ?? null;
                if ($firstImage !== $this->product->thumbnail) {
                    array_unshift($images, [
                        'variantId' => null,
                        'image'     => $this->product->thumbnail,
                    ]);
                }
            }
        } elseif ($this->product->thumbnail) {
            $images[] = [
                'variantId' => null,
                'image'     => $this->product->thumbnail,
            ];
        }

        return $images;
    }

    public function submitOrder(): void
    {
        $this->validate([
            'customerName'    => 'required|min:2|max:255',
            'recipientName'   => 'required|min:2|max:255',
            'deliveryAddress' => 'required|min:5|max:1000',
            'deliveryDate'    => 'required|date',
        ]);

        $waNumber = Setting::get('whatsapp_number', '6281234567890');
        $waNumber = preg_replace('/[^0-9]/', '', $waNumber);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }

        $variant     = $this->selected_variant;
        $activePrice = $this->active_price;
        $activeDesc  = $this->active_description;

        // Susun label varian
        $variantLabel = null;
        if ($variant) {
            $variantLabel = ($variant->description && $variant->description !== '')
                ? $variant->description
                : 'Varian ' . ($this->product->variants->search(fn ($v) => $v->id === $variant->id) + 1);
        }

        // Format tanggal lebih ramah
        $deliveryDateFormatted = $this->deliveryDate
            ? \Carbon\Carbon::parse($this->deliveryDate)->translatedFormat('d F Y')
            : $this->deliveryDate;

        // Bangun pesan — gunakan karakter ASCII biasa agar aman di URL
        $line = str_repeat('-', 30);

        $msg  = "Halo, saya ingin memesan bunga :)\n\n";
        $msg .= $line . "\n";
        $msg .= "*DETAIL PESANAN*\n";
        $msg .= $line . "\n";
        $msg .= "Produk      : {$this->product->name}\n";

        if ($variantLabel) {
            $msg .= "Varian      : {$variantLabel}\n";
        }

        if ($activePrice) {
            $msg .= 'Harga       : Rp ' . number_format((float) $activePrice, 0, ',', '.') . "\n";
        }

        if ($activeDesc) {
            $msg .= "Keterangan  : {$activeDesc}\n";
        }

        $msg .= "\n" . $line . "\n";
        $msg .= "*DATA PEMESAN*\n";
        $msg .= $line . "\n";
        $msg .= "Nama Pemesan : {$this->customerName}\n";

        $msg .= "\n" . $line . "\n";
        $msg .= "*DATA PENGIRIMAN*\n";
        $msg .= $line . "\n";
        $msg .= "Pengirim     : {$this->customerName}\n";
        $msg .= "Penerima     : {$this->recipientName}\n";
        $msg .= "Alamat       : {$this->deliveryAddress}\n";
        $msg .= "Tgl Kirim    : {$deliveryDateFormatted}\n";

        if ($this->greetingMessage) {
            $msg .= "\n" . $line . "\n";
            $msg .= "*UCAPAN*\n";
            $msg .= $line . "\n";
            $msg .= $this->greetingMessage . "\n";
        }

        if ($this->notes) {
            $msg .= "\n" . $line . "\n";
            $msg .= "*CATATAN*\n";
            $msg .= $line . "\n";
            $msg .= $this->notes . "\n";
        }

        $msg .= "\nTerima kasih :)";

        // rawurlencode agar spasi jadi %20, bukan +, dan karakter khusus aman
        $this->redirect("https://wa.me/{$waNumber}?text=" . rawurlencode($msg));
    }

    public function render()
    {
        return view('livewire.storefront.product-detail', [
            'relatedProducts' => Product::active()
                ->where('category_id', $this->product->category_id)
                ->where('id', '!=', $this->product->id)
                ->with(['category', 'variants'])
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }
}
