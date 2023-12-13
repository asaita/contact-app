<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AllowedFilterSearch
{

    public function scopeAllowedFilters(Builder $query, ...$keys){

        foreach($keys as $key){

            if ($value=request($key)){
                $query->where($key,$value);
            }
        }

        return $query;
    }

    public function scopeAllowedSearch(Builder $query, ...$keys){

        
        
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

    public function scopeAllowedTrash(Builder $query){

        if(request()->query('trash')){
            $query->onlyTrashed();
        }

        return $query;
        
    }

}

?>