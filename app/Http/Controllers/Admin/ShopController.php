<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopBundle;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    // ─── Bundles ────────────────────────────────────────────────────────────

    public function index()
    {
        $bundles  = ShopBundle::withCount('products')->orderBy('sort_order')->get();
        $products = ShopProduct::whereNull('bundle_id')->orderBy('sort_order')->get();

        $stats = [
            'bundles'       => $bundles->count(),
            'products'      => ShopProduct::count(),
            'out_of_stock'  => ShopProduct::where('in_stock', false)->count(),
        ];

        return view('admin.shop.index', compact('bundles', 'products', 'stats'));
    }

    // ── Bundle CRUD ──────────────────────────────────────────────────────────

    public function createBundle()
    {
        return view('admin.shop.bundle-create');
    }

    public function storeBundle(Request $request)
    {
        $validated = $this->validateBundle($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shop', 'public');
        }

        ShopBundle::create($validated);

        return redirect()->route('admin.shop.index')
            ->with('success', 'تم إضافة المجموعة بنجاح.');
    }

    public function editBundle(ShopBundle $bundle)
    {
        $bundle->load('products');
        return view('admin.shop.bundle-edit', compact('bundle'));
    }

    public function updateBundle(Request $request, ShopBundle $bundle)
    {
        $validated = $this->validateBundle($request);

        if ($request->hasFile('image')) {
            if ($bundle->image) Storage::disk('public')->delete($bundle->image);
            $validated['image'] = $request->file('image')->store('shop', 'public');
        }

        $bundle->update($validated);

        return redirect()->route('admin.shop.index')
            ->with('success', 'تم تحديث المجموعة.');
    }

    public function destroyBundle(ShopBundle $bundle)
    {
        if ($bundle->image) Storage::disk('public')->delete($bundle->image);
        $bundle->products()->update(['bundle_id' => null]); // detach products
        $bundle->delete();

        return back()->with('success', 'تم حذف المجموعة.');
    }

    // ── Product CRUD ─────────────────────────────────────────────────────────

    public function createProduct()
    {
        $bundles = ShopBundle::active()->get();
        return view('admin.shop.product-create', compact('bundles'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shop', 'public');
        }

        ShopProduct::create($validated);

        return redirect()->route('admin.shop.index')
            ->with('success', 'تم إضافة المنتج بنجاح.');
    }

    public function editProduct(ShopProduct $product)
    {
        $bundles = ShopBundle::active()->get();
        return view('admin.shop.product-edit', compact('product', 'bundles'));
    }

    public function updateProduct(Request $request, ShopProduct $product)
    {
        $validated = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $validated['image'] = $request->file('image')->store('shop', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.shop.index')
            ->with('success', 'تم تحديث المنتج.');
    }

    public function destroyProduct(ShopProduct $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return back()->with('success', 'تم حذف المنتج.');
    }

    public function toggleStock(ShopProduct $product)
    {
        $product->update(['in_stock' => !$product->in_stock]);
        $msg = $product->in_stock ? 'المنتج متاح الآن.' : 'المنتج نفذ من المخزون.';
        return back()->with('success', $msg);
    }

    // ─── Validation ──────────────────────────────────────────────────────────

    private function validateBundle(Request $request): array
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:1000',
            'image'         => 'nullable|image|max:5120',
            'color_variant' => 'nullable|string|max:50',
            'price'         => 'required|integer|min:0',
            'is_active'     => 'nullable|boolean',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        return $data;
    }

    private function validateProduct(Request $request): array
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|max:5120',
            'price'       => 'required|integer|min:0',
            'size_label'  => 'nullable|string|max:50',
            'bundle_id'   => 'nullable|exists:shop_bundles,id',
            'in_stock'    => 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data['in_stock']   = $request->boolean('in_stock');
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        return $data;
    }
}
