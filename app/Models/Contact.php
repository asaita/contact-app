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

    public function scopeAllowedSorts(Builder $query, string $column)
    {
        return $query->orderBy($column);
    }

    public function scopeAllowedFilters(Builder $query, string $key){
        if ($companyId=request($key)){
            $query->where($key,$companyId);
        }

        return $query;
    }

    public function scopeAllowedSearch(Builder $query, array $keys){

        
        
        if($search=request('search')){

            foreach ($keys as $index => $key) {
                $method=$index===0?'where':'orWhere';
                $query->$method($key,'LIKE',"%{$search}%");
            }

            // $query->where('first_name','LIKE',"%{$search}%");
            // $query->orwhere('last_name','LIKE',"%{$search}%"); 
            // $query->orwhere('email','LIKE',"%{$search}%");  

        }

        return $query;
    }


    
  
}
