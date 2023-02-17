<?php

namespace App\Http\Controllers\Backend;

use datatables;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Company as CompanyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('backend.company.index');
    }


    public function ssd(){
        $data = Company::query();
        return datatables()->of($data)
        ->editColumn('logo',function($each){
            return '<img src="'.$each->logo_image_path().'" width="80px" height="80px"/>';
        })
        ->editColumn('website',function($each){
            return '<a href="'.$each->website.'" target="_blank">'.$each->website.'</a>';
        })
        ->editColumn('created_at',function($each){
            return $each->created_at->format('Y-m-d');
        })
        ->addColumn('action',function($each){
            $edit_icon = '<a href="'.route('admin.company.edit',$each->id).'" class="text-warning mr-2"><i class="fa-solid fa-pen-to-square"></i></a>';
            $info_icon = '<a href="'.route('admin.company.show',$each->id).'" class="text-primary mr-2"><i class="fa-solid fa-circle-info"></i></a>';
            $delete_icon = '<a href="#" data-id="'.$each->id.'" class="text-danger delete_btn"><i class="fa-solid fa-trash"></i></a>';
            return "$edit_icon" . "$info_icon" . "$delete_icon";
        })
        ->rawColumns(['logo','website','action'])
        ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $logo_image_name = null;
        if($request->file('logo')){
            $logo_image_file = $request->file('logo');
            $logo_image_name = uniqid() . '_' . uniqid() .'.'.$logo_image_file->getClientOriginalExtension();
            Storage::disk('public')->put('/backend/logo/'.$logo_image_name ,file_get_contents($logo_image_file));
        }

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $logo_image_name;
        $company->website = $request->website;
        $company->save();
        Mail::to($company->email)->send(new CompanyMail($company->name));
        return redirect()->route('admin.company.index')->with('success','Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('backend.company.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('backend.company.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $logo_image_name = $company->logo;
        if($request->file('logo')){
            Storage::disk('public')->delete('/backend/logo/'.$company->logo);
            $logo_image_file = $request->file('logo');
            $logo_image_name = uniqid() . '_' . uniqid() .'.'.$logo_image_file->getClientOriginalExtension();
            Storage::disk('public')->put('/backend/logo/'.$logo_image_name ,file_get_contents($logo_image_file));
        }   
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $logo_image_name;
        $company->website = $request->website;
        $company->update();
        return redirect()->route('admin.company.index')->with('success','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if($company->logo){
            Storage::disk('public')->delete('/backend/logo/'.$company->logo);
        }
        $company->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Successfully deleted'
        ]);
    }
}
