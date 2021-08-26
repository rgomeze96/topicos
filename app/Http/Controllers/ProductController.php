<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller

{
    public function show($id)

    {
        try {
            $data = []; //to be sent to the view
            $product = Product::findOrFail($id);
            $listOfSizes = array("XS", "S", "M", "L", "XL");
            $data["title"] = $product->getName();
            $data["product"] = $product;
            $data["sizes"] = $listOfSizes;
            return view('product.show')->with("data", $data);
        } catch (ModelNotFoundException $err) {
            return redirect()->route('home.index');
        }
    }
    public function list($id)
    {
        $data = []; //to be sent to the view
        $data["title"] = "Create product";
        return view('product.create')->with("data", $data);
    }
    public function create()
    {
        $data = []; //to be sent to the view
        $data["title"] = "Create product";
        $data["products"] = Product::all();
        return view('product.create')->with("data", $data);
    }
    public function save(Request $request)
    {
        $request->validate([
            "name" => "required",
            "price" => "required|numeric|gt:0"
        ]);
        Product::create($request->only(["name", "price"]));
        return back()->with('success', 'Item created successfully!');
    }
}
