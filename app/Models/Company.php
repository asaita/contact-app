<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    //protected $guarded =[];
    protected $fillable = ['name','adres','email'];
    
    public function contact()
    {

        //bir company birden fazla contact olduğu için bu şekilde bağlantı kuruldu (1 to n)
    return $this->hasMany(Contact::class);

    }
}
