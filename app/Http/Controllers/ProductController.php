<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();

        $query = Product::with('category', 'brand');
        
        // Lọc theo Category 
        $query->when($request->category, function ($q, $categorySlug) {
            $q->whereHas('category', function($subQ) use ($categorySlug) {
                $subQ->where('slug', $categorySlug);
            });
        });

        // Lọc theo Brand 
        $query->when($request->brand, function ($q, $brandSlug) {
            $q->whereHas('brand', function($subQ) use ($brandSlug) {
                $subQ->where('slug', $brandSlug);
            });
        });

        // Xử lý TÌM KIẾM
        $query->when($request->search, function ($q, $search) {
            $q->where('name', 'LIKE', "%{$search}%");
        });

        // Xử lý PHÂN TRANG
        $products = $query->latest()->paginate(12)->withQueryString();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Hiển thị trang chi tiết sản phẩm
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with([
                'images',
                'category',
                'brand',
                // Chỉ tải các review đã được duyệt và tải kèm user của review đó
                'reviews' => function ($query) {
                    $query->where('status', 'approved')->with('user')->latest();
                }
            ])
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
