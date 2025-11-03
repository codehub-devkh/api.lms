<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function store(Request $request){
        $category = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $slug = Str::slug($request->input('name'),'-');
        $response = Category::create(array_merge($category, ['slug' => $slug]));
        return $this->created('Category created successfully', $response);
    }

    public function index()
    {
        $response = Category::orderBy('id', 'desc')->get();
        if($response->isEmpty()){
            return $this->notFound("Category not found");
        }
        return $this->success("Category retrieved successfully", $response);
    }

    public function show($id)
    {
        $response = Category::find($id);
        if(is_null($response)){
            return $this->notFound("Category not found");
        }
        return $this->success("Category retrieved successfully", $response);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $category = Category::find($id);
        if(is_null($category)){
            return $this->notFound("Category not found");
        }
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required','string','min:3','max:50','unique:categories,name,' . $id],
            'description' => ['nullable','string','max:255'],
        ]);
        $slug = Str::slug($request->input('name'), '-');
        $category->update(array_merge($validated, ['slug' => $slug]));
        return $this->success('Category updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->notFound("Category not found");
        }
        $request->validate([
            'id' => ['required', 'integer', 'exists:categories,id'],
        ]);
        $category->delete();
        return $this->success('Category deleted successfully');
    }

}
