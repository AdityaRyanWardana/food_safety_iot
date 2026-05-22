<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller
{
    public function index()
    {
        $categories = FoodCategory::withCount(['sensorReadings', 'contaminationLogs'])
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);

        FoodCategory::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori pangan berhasil ditambahkan.');
    }

    public function update(Request $request, FoodCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori pangan berhasil diperbarui.');
    }

    public function destroy(FoodCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori pangan berhasil dihapus.');
    }
}
