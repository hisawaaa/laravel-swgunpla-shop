<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Brand::query();

        // Xử lý TÌM KIẾM
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Xử lý PHÂN TRANG
        $brands = $query->latest()->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xử lý VALIDATION
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($request->name);

        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return redirect()->route('admin.brands.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        // Xử lý VALIDATION
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($request->name);

        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công.');
    }
}
