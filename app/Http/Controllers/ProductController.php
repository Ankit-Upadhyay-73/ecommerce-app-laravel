<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $offeredProducts = Product::where('Discount','>',0)->orderBy("Discount", "desc")->take(3)->get();
        $product = Product::with('ratings')->get();
        if($request->input('name')!="")
        {
            $product = Product::where('Name', 'like', $request->input('name').'%')->get();
        }        

        if($request->input('discount')!="" || $request->input('price')!="" || $request->input('rating')!="")
        {
            $product = Product::where("Discount",">=",$request->input('discount'))->where("Price","<=",$request->input('price'))->get();
            return view('UsersSide.Home')->with(["products"=>$product,"offeredProducts"=>$offeredProducts]);
        }

        return view('UsersSide.Home')->with(["products"=>$product,"offeredProducts"=>$offeredProducts]);

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
        
        // Validate the inputs
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required',
            'quantity'=> 'required',
            'discount'=> 'required|lte:100',
        ]);

        if ($request->hasFile('file')) {

            $request->validate([
                'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('product', 'public');

            // Store the record, using the new file hashname which will be it's new filename identity.
            $product = new Product();
            $product->Name = $request->input('name');
            $product->Description = $request->input('desc');
            $product->Price = $request->input('price');
            $product->Quantity = $request->input('quantity');
            $product->Discount = $request->input('discount');
            $product->img_name = $request->file->hashName();
            $product->save(); // Finally, save the record.
            $rating = new Rating();
            $rating->rating = 1;
            $rating->save();    
            
            $product->ratings()->attach(1);
        }

        return Redirect::to('/home');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        
        $product = Product::where([            
            ["Name",'=',$name],
        ])->get();

        $offeredProducts = Product::where('Discount','>',0)->orderBy("Discount", "asc")->take(3)->get();
        return view('UsersSide.Home')->with(["products"=>$product,"offeredProducts"=>$offeredProducts]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rating(Request $request)
    {
        return $request->all();
    }

}
