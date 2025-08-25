<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JewelryCategory;

class JewelryCategoryController extends Controller
{
    public function index()
    {
        $categories=JewelryCategory::all();
        return view('jewelleryCategory.index',compact('categories'));
    }

    public function choice($id)
    {
        return $id;
    }
}
