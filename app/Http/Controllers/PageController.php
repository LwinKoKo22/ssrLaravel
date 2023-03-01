<?php

namespace App\Http\Controllers;

use App\Models\Feature;

class PageController extends Controller
{
    public function index(){
        $features = Feature::all();
        return view('feature-room.welcome',compact('features'));
    }

    public function feature_detail(Feature $feature){
        return view('feature-room.feature_detail',compact('feature'));
    }

    public function image(){
        if (request()->img) {
            $file = request()->img;
            $name = uniqid() . $file->getClientOriginalName();
            $file->move(public_path('/images'), $name);
            return "success";
            // return asset('images/' . $name);
        }
    }
}
