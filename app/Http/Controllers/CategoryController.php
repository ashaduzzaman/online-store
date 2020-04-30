<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        logger($categories);
        foreach($categories as $category){
            $category['imgUrl'] = '/images/'.$category->image;
        }

        return response()->json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // logger($request);
        $validatedData = $request->validate([
            'name' => 'required|max:190',
            'image' => 'required'
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
        $category = Category::create($data);

        return response()->json($category, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category = Category::where('id', $request->id)
                            ->update(
                                [
                                    'name' => $request->name,
                                    'image' => $request->image    
                                ]
                            );
        // return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $isProduct = Product::where('category_id', $category->id)->count();
        logger($isProduct);
        if($isProduct == 0){
            $category_delete = Category::find($category->id);
            $category_delete->delete();
        } else {
            logger('not allowed');
        }
    }
}
