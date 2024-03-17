<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class productController extends Controller
{
    function addproduct(Request $request){
        try{
           $field = $request->validate([
                'image' => 'required|mimes:jpg,png,jpeg|file',
                'product_name' => 'required',
                'product_price' => 'required',
                'product_keyword' => 'required'
            ]);            
        } catch (ValidationException $exc){
            return response() -> json($exc->errors());
        }
        
        try{
            // process the image
            $image = $request->file('image');
            $newFilename = time() .'lynne_enterprise'.'.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $newFilename);
            // add things to the database
            Product::create([
                "name" => $field['product_name'],
                'keyword' => $field['product_keyword'],
                'price' => $field['product_price'],
                'image_link' => $newFilename
            ]);
            // return message
            return response() -> json([
                "message" => "successfully added",
            ]);            
        } catch(\Throwable $th){
            return response() -> json($th);
        }
    }
    
    
    public function getproduct(){
        $products = Product::all();
        foreach ($products as $product) {
            $product->image_link = asset('images/' . $product->image_link);
        }
        return response() -> json([
            "message" => $products
        ]);
    }
    
        
    
    public function deleteproduct(Request $request){
        $product = Product::where('id',$request->id)->first();
        $product -> delete();
        return response() -> json([
            "message" => $request->id." deleted successfully"
        ]);
    }
    
    
    public function editProduct(Request $request){
        $id = $request -> id;
        $product_name = $request -> name;
        $product_price = $request ->price;
        $product_keyword = $request -> keyword;
        
        $product = Product::find($id);
        $product -> name = $product_name;
        $product -> price = $product_price;
        $product -> keyword = $product_keyword;
        $product -> save();
        return response() -> json([
            "message" => "product updated"
        ]);
    }
}
