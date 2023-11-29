<?php

namespace App\Models;

use App\Models\Scopes\SimpleSoftDeletingScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;// global scope için bunu sildik SoftDeletes;

    protected $fillable =['first_name','last_name','email','phone','address','company_id'];

    public function Company(){

        //her contact bir şirkete ait olduğu için bu şekilde ilişki(relationship) kuruldu.(1 to 1)
        return $this->belongsTo(Company::class);
    }

    public function tasks(){
      
        //her contactın birden fazla taskı olabilir
        return $this->hasMany(Task::class);
    }

    protected static function booted() {
       
        static::addGlobalScope(new SimpleSoftDeletingScope);
    }
}
