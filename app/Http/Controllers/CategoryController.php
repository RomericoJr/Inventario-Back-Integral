<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function newCategory(Request $req){
        $category = category::create($req->all());
        return response($category, 200);
    }
    public function getCategories(){
        return response()->json(category::all(), 200);
    }

    public function getCategoryById($id){
        $category = category::find($id);
        if(is_null($category)){
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category::find($id), 200);
    }

    public function deleteCategory($id){
        $category = category::find($id);
        if(is_null($category)){
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(null, 204);
    }

    public function updateCategory($id, $request){
        $category = category::find($id);
        if(is_null($category)){
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->update($request->all());
        return response($category, 200);
    }
}
