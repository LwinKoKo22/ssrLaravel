<?php

namespace App\Http\Controllers\Backend;

use datatables;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('backend.employee.index',compact('companies'));
    }

    public function ssd(){
        $data = Employee::query();
        if(request()->name){
            $data = $data->where('email','LIKE','%'.request()->name.'%')->orWhere('phone','LIKE','%'.request()->name.'%');
        }
        if(request()->date){
            $date = explode("-",request()->date);
            $from = $date[0];
            $to = $date[1];
            $data = $data->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }
        if(request()->company){
            $value = request()->company;
            $data = $data->whereHas('company',function($query) use($value){
                $query->where('id',$value);   
            });
        }

        return datatables()->of($data)
        ->addColumn('company',function($each){
            return $each->company ? $each->company->name : "-";
        })
        ->addColumn('name',function($each){
            return $each->fname ." ". $each->lname;
        })
        ->editColumn('created_at',function($each){
            return $each->created_at->format('Y-m-d');
        })
        ->addColumn('action',function($each){
            $edit_icon = '<a href="'.route('admin.employee.edit',$each->id).'" class="text-warning mr-2"><i class="fa-solid fa-pen-to-square"></i></a>';
            $info_icon = '<a href="'.route('admin.employee.show',$each->id).'" class="text-primary mr-2"><i class="fa-solid fa-circle-info"></i></a>';
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
        $compaines = Company::all();
        return view('backend.employee.create',compact('compaines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = new Employee();
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->company_id = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();
        return redirect()->route('admin.employee.index')->with('success','Successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('backend.employee.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $compaines = Company::all();
        return view('backend.employee.edit',compact('employee','compaines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->company_id = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->update();
        return redirect()->route('admin.employee.index')->with('success','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Successfully deleted'
        ]);
    }
}
