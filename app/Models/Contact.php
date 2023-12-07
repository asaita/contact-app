<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory,SoftDeletes;// global scope için bunu sildik SoftDeletes;

    protected $fillable =['first_name','last_name','email','phone','address','company_id'];

    public function Company(){

        //her contact bir şirkete ait olduğu için bu şekilde ilişki(relationship) kuruldu.(1 to 1)
        return $this->belongsTo(Company::class);
    }

    public function tasks(){
      
        //her contactın birden fazla taskı olabilir
        return $this->hasMany(Task::class);
    }

    public function scopeSortByNameAlpha(Builder $query)
    {
        return $query->orderBy('first_name');
    }

    public function scopeFilterByCompany(Builder $query){
        if ($companyId=request('company_id')){
            $query->where('company_id',$companyId);
        }

        return $query;
    }

    
  
}
