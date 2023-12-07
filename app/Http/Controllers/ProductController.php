<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function newProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'price_sale' => 'required|numeric',
            'stock' => 'required',
            'expired' => 'required',
            'image' => 'required|image|',
            // 'image' => 'required|image|max:2048',
            'category_id' => 'required',
            // 'state' => 'required',
            // 'precio' => 'required|numeric|regex:/^\d{1,4}(\.\d{1,2})?$/|max:9999.99',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $rutaArchivoImg = $request->file('image')->store('public/imgproductos');
        $producto = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'price_sale' => $request->price_sale,
            'stock' => $request->stock,
            'expired' => $request->expired,
            'image' => $rutaArchivoImg,
            'category_id' => $request->category_id,

        ]);

        return response()->json(['producto' => $producto], 201);
    }

    //función para actualizar el producto usando el id del producto
    public function updateProduct(Request $request, $id)
    {
        $product = product::find($id);
        if(is_null($product)){
            return response()->json(['message' => 'Product Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'price_sale' => 'required|numeric',
            'stock' => 'required',
            'expired' => 'required',
            'image' => 'image',
            'category_id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('image')) {
            $rutaArchivoImg = $request->file('image')->store('public/imgproductos');
        } else {
            $rutaArchivoImg = $product->image; // Otra ruta de imagen existente o un valor predeterminado
        }
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'price_sale' => $request->price_sale,
            'stock' => $request->stock,
            'expired' => $request->expired,
            'image' => $rutaArchivoImg,
            'category_id' => $request->category_id,

        ]);

        return response()->json(['producto' => $product], 201);
    }


    public function getProductByIdsaas($id){
        $product = product::find($id);
        if(is_null($product)){
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $product->image = asset(Storage::url($product->image));
        // return response()->json(product::find($id), 200);
        return response()->json($product, 200);
    }

    public function getProduct(){
        $products = product::all();

        foreach ($products as $product) {
            $product->image = asset(Storage::url($product->image));
        }

        return response($products, 200);
    }

    public function getProductById($id){
        $product = product::find($id);
        if(is_null($product)){
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        return response($product, 200);
    }

    public function deleteProduct($id){
        $product = product::find($id);
        if(is_null($product)){
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product Deleted'], 200);
    }
}
