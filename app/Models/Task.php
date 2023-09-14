<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public function contact(){

        //her taskın bir tane contactı var. bir contacta bağlı
        return $this->belongsTo(Contact::class);

    }
}
