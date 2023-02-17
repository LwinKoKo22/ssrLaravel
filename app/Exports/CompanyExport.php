<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompanyExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Email',
            'Website',
            'Created_at',
            'Updated_at' 
        ];
    } 

    public function collection()
    {
        return Company::all();
    }
}
