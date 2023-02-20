<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class EmployeeExport implements FromView
{
    protected $search;
    protected $date;
    protected $company;
    public function __construct($search , $date ,$company){
        $this->search = $search;
        $this->date = $date;
        $this->company = $company;
    }

    public function view():View{
        $data = Employee::query();
        if($this->search){
            $data = $data->where('email','LIKE','%'.$this->search.'%')->orWhere('phone','LIKE','%'.$this->search.'%');
        }
        if($this->date){
            $date = explode("-",$this->date);
            $from = $date[0];
            $to = $date[1];
            $data = $data->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }
        if($this->company){
            $value = $this->company;
            $data = $data->whereHas('company',function($query) use($value){
                $query->where('id',$value);   
            });
        }

        return view('backend.excel.employee',[
            'employees'=>$data->get()
        ]);
    }
}
