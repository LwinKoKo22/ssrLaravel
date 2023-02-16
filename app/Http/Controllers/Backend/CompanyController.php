<?php

namespace App\Http\Controllers\Backend;

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
        $companies = Company::all();
        return view('backend.company.index',compact('companies'));
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
        return redirect()->route('admin.company.index')->with('success','Successfully deleted');
    }
}
