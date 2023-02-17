<?php

namespace App\Http\Controllers\Backend;

use App\Models\Company;
use App\Models\Employee;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index(){
        $company_count = Company::count();
        $employee_count = Employee::with('company')->count();
        return view('backend.dashboard',compact('company_count','employee_count'));
    }
}
