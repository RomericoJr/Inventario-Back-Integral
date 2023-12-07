<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    //
    public function newSale(Request $req)
    {
        try {
            $validate = Validator::make($req->all(), [
                'amount' => 'required|numeric',
                'total' => 'required|numeric',
                'profit' => 'required|numeric',
                'hour' => 'required',
                'product_id' => 'required|numeric',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en la validación de datos',
                    'error' => $validate->errors(),
                ], 422);
            }

            $product = Product::find($req->input('product_id'));

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado',
                ], 404);
            }

            $newSale = Sale::create([
                'amount' => $req->input('amount'),
                'total' => $req->input('total'),
                'profit' => $req->input('profit'),
                'hour' => $req->input('hour'),
                'product_id' => $req->input('product_id'),
            ]);

            $descuento = $product->stock - $req->input('amount');

            $product->update([
                'stock' => $descuento,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Venta realizada y producto actualizado',
                'data' => [
                    'newSale' => $newSale,
                    'updatedProduct' => $product,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al realizar la venta',
                'errors' => $e->getMessage(),
            ], 400);
        }
    }

    public function getSale(){

        return response()->json(sale::with('product')->get(), 200);
    }

    public function deleteSale($id){
        $sale = sale::find($id);
        if(is_null($sale)){
            return response()->json(['message' => 'Sale not found'], 404);
        }
        $sale->delete();
        return response()->json(null, 204);
    }
}
