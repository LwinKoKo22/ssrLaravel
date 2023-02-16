<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function logo_image_path(){
        if($this->logo){
            return asset('/storage/backend/logo/'.$this->logo);
        }
        return "-";
    }
}
