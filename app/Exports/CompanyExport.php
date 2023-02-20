<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyExport implements FromView
{
    protected $search;
    protected $date;
    public function __construct($search , $date){
        $this->search = $search;
        $this->date = $date;
    }

    public function view(): View
    {

        $data = Company::query();
        if($this->search){
            $data = $data->where('name','LIKE','%'.$this->search.'%');
        }
       
        if($this->date){
            $date = explode("-",$this->date);
            $from = $date[0];
            $to = $date[1];
            $data = $data->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }
        return view('backend.excel.company', [
            'companies' => $data->get()
        ]);
    }
}
