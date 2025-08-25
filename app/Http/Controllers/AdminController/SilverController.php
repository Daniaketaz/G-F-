<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\GoldProduct;
use App\Models\JewelryCategory;
use App\Models\Product;
use App\Models\SilverProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SilverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $silvers = SilverProduct::all();
        return view('Silver Section.select', compact('silvers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Silver Section.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::query();
        $input=new SilverProduct();
        $input->description=$request->description;
        $input->weight=$request->weight;
        $input->formulation_price=$request->formulation_price;
        $input->accessories_price=$request->accessories_price;
        $image = $request->file('image')->getClientOriginalName();
        $file_name=time().'.'. $image;
        $path='images/silver';
        $file=$request->image->move($path,$file_name);
        $val=1;
        $product->create(['product-type-id'=>$val]);
        $category=$request->jewelry_category;
        $category_B = JewelryCategory::query()->where('jewelry_category', $category)->first();
        $category_id=[];
        if($category_B)
        {
            $category_id=$category_B->id;
        }
        $final_price=($input->weight * $input->accessories_price)+$input->formulation_price;
        $input = SilverProduct::query()->create(['final_price'=>$final_price,'accessories_price'=>$input->accessories_price,'formulation_price'=>$input->formulation_price,'photo' => $file,'description'=>$input->description,'weight'=>$input->weight,'jewelry-categories-id'=>$category_id, 'product-id' => Product::query()->latest()->pluck('id')->first()]);
        $input->save();
        return redirect()->route('silver.index')->with('success','product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($silverProduct)
    {
        return view('Silver Section.show',[
            'silverProduct'=>SilverProduct::findOrFail($silverProduct)
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($silverProduct)
    {
        return view('Silver Section.edit',[
            'silverProduct'=>GoldProduct::findOrFail($silverProduct)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $silverProduct)
    {
        $to_update=SilverProduct::findOrFail($silverProduct);
        $to_update->weight=strip_tags($request->input('weight'));
        $to_update->description=strip_tags($request->input('description'));
        $to_update->accessories_price=strip_tags($request->input('accessories_price'));
        $to_update->formulation_price=strip_tags($request->input('formulation_price'));
        $to_update->save();
        return redirect()->route('silver.index')->with('success','product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function seeSilverRings()
    {
        $silvers= SilverProduct::query()->where('jewelry-categories-id',1)->get();
        return view('Silver Section.select', compact('silvers'));
    }

    public function seeSilverBracelet()
    {
        $silvers= SilverProduct::query()->where('jewelry-categories-id',2)->get();
        return view('Silver Section.select', compact('silvers'));
    }

    public function seeSilverEarrings()
    {
        $silvers= SilverProduct::query()->where('jewelry-categories-id',3)->get();
        return view('Silver Section.select', compact('silvers'));
    }

    public function seeSilverNecklace()
    {
        $silvers= SilverProduct::query()->where('jewelry-categories-id',4)->get();
        return view('Silver Section.select', compact('silvers'));
    }




    public function destroy($silverProduct)
    {
        $to_delete=SilverProduct::findOrFail($silverProduct);
        $to_delete->delete();
        return redirect()->route('silver.index');
    }
}
