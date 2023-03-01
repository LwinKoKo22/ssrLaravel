<?php

namespace App\Http\Controllers\Backend;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.feature.index');
    }

    public function ssd(){
        $data = Feature::query();
        return datatables()->of($data->get())
        ->editColumn('feature_image',function($each){
            if($each->feature_image){
                return '<img src="'.$each->feature_image_path().'" width="80px" height="80px"/>';
            }else{
                return '<img src="https://via.placeholder.com/80x80" width="80px" height="80px"/>';
            }
        })
        ->editColumn('created_at',function($each){
            return $each->created_at->format('Y-m-d');
        })
        ->addColumn('action',function($each){
            $edit_icon = '<a href="'.route('admin.feature.edit',$each->id).'" class="text-warning mr-2"><i class="fa-solid fa-pen-to-square"></i></a>';
            $info_icon = '<a href="'.route('admin.feature.show',$each->id).'" class="text-primary mr-2"><i class="fa-solid fa-circle-info"></i></a>';
            $delete_icon = '<a href="#" data-id="'.$each->id.'" class="text-danger delete_btn"><i class="fa-solid fa-trash"></i></a>';
            return "$edit_icon" . "$info_icon" . "$delete_icon";
        })
        ->rawColumns(['feature_image','action'])
        ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.feature.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeatureRequest $request)
    {
        $feature_image_name = null;
        if($request->file('feature_image')){
            $feature_image_file = $request->file('feature_image');
            $feature_image_name = uniqid() . '_' . uniqid() .'.'.$feature_image_file->getClientOriginalExtension();
            Storage::disk('public')->put('/backend/featureImage/'.$feature_image_name ,file_get_contents($feature_image_file));
        }

        $feature = new Feature();
        $feature->name = $request->name;
        $feature->feature_image = $feature_image_name;
        $feature->save();
        return redirect()->route('admin.feature.index')->with('success','Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
      return view('backend.feature.show',compact('feature')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return view('backend.feature.edit',compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $feature_image_name = $feature->feature_image;
        if($request->file('feature_image')){
            Storage::disk('public')->delete('/backend/featureImage/'.$feature->feature_image);
            $feature_image_file = $request->file('feature_image');
            $feature_image_name = uniqid() . '_' . uniqid() .'.'.$feature_image_file->getClientOriginalExtension();
            Storage::disk('public')->put('/backend/featureImage/'.$feature_image_name ,file_get_contents($feature_image_file));
        }   
        $feature->name = $request->name;
        $feature->feature_image = $feature_image_name;
        $feature->update();
        return redirect()->route('admin.feature.index')->with('success','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        if($feature->feature_image){
            Storage::disk('public')->delete('/backend/featureImage/'.$feature->feature_image);
        }
        $feature->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Successfully deleted'
        ]);
    }
    }

