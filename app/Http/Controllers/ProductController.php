<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('category')->get(),200);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:190',
            'category_id' => 'required',
            'units' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);
            $data = [];

            if ($request->filled('image')) {
                logger('has');
                logger($request->all());
                $exploded = explode(',', $request->image);
                $decoded = base64_decode($exploded[1]);

                if(str_contains($exploded[0], 'jpeg'))
                    $extension = 'jpg';
                else
                    $extension = 'png';

                $fileName = str_random().'.'.$extension;
                
                $path = public_path().'/images/'.$fileName;

                file_put_contents($path, $decoded);

                $data['image'] = $fileName;
            }

            $data['name'] = $request->name;
            $data['category_id'] = $request->category_id;
            $data['description'] = $request->description;
            $data['units'] = $request->units;
            $data['price'] = $request->price;
            $product = Product::create($data);
        
        return response()->json([
            'status' => (bool) $product,
            'data'   => $product,
            'message' => $product ? 'Product Created!' : 'Error Creating Product'
        ]);
    }
    
    public function show($id)
    {
        logger($id);
        $products = Product::where('category_id', $id)->with('category')->get();
        logger($products);
        return response()->json($products,200); 
    }

    public function uploadFile(Request $request)
    {
        if($request->hasFile('image')){
            $name = time()."_".$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $name);
        }
        return response()->json(asset("images/$name"),201);
    }

    public function update(Request $request, Product $product)
    {
        $status = $product->update(
            $request->only(['name', 'description', 'units', 'price', 'image'])
        );
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product'
        ]);
    }
    
    public function updateUnits(Request $request, Product $product)
    {
        $product->units = $product->units + $request->get('units');
        $status = $product->save();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
        ]);
    }

    public function destroy(Product $product)
    {
        $status = $product->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
        ]);
    }
}
