<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function feature_image_path(){
        if($this->feature_image){
            return asset('/storage/backend/featureImage/'.$this->feature_image);
        }
        return "-";
    }
    
}
