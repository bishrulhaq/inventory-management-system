<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
     public function __construct(){
     	$this->middleware('auth');
     }

    public function store(Request $request){

        $rules = [
            'code' => 'required|unique:products,product_code',
            'name' => 'required',
            'category' => 'required',
            'stock' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
        ];

        $messages = [
            'stock.numeric' => 'Stock must be a number.',
            'unit_price.numeric' => 'Buy Price must be a number.',
            'sale_price.numeric' => 'Sale Price must be a number.',
        ];

        $this->validate($request, $rules, $messages);

        $product = new Product;
        $product->product_code = $request->code;
        $product->name = $request->name;
        $product->category = $request->category;
        $product->stock = $request->stock;
        $product->unit_price = $request->unit_price;
        $product->sales_unit_price = $request->sale_price;

        if ($product->save()) {
            return redirect()->route('add.product')->with('message', 'Product added successfully!');
        } else {
            return redirect()->route('add.product')->with('message', 'Failed to add the product.');
        }
    }

    public function allProduct(){
    	$products = Product::all();
    	return view('Admin.all_product',compact('products'));
    }

    public function availableProducts(){
        $products = Product::where('stock','>','0')->get();
        return view('Admin.available_products',compact('products'));
    }

    public function formData($id){
        $product = Product::find($id);

        return view('Admin.add_order',compact('product'));
        // return view('Admin.add_order',['product'=>$product]);
    }

    public function purchaseData($id){
        $product = Product::find($id);

        return view('Admin.purchase_products',compact('product'));
    }

    public function storePurchase(Request $request){

        Product::where('name',$request->name)->update(['stock' => $request->stock + $request->purchase]);

        return Redirect()->route('all.product');
    }


}
