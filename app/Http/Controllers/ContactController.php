<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Company;

class ContactController extends Controller
{
    public function index(){

        //pluck metodu veritabanından dizi şeklinde veri çekmeye yarıyor. 
        //orderby ise çekilen veriyi isime göre sıralıyor
        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');

        // $contacts = Contact::all();
        //aşağıdaki satır üstdeki satırdan farklı olarak isim sütununu a den z ye doğru sıralıyor
        //$contacts=Contact::orderBy('first_name','asc')->get();

        //Aşağıdan SAYFALAMA yapmamızı sağlıyor. javascript ile gelen company idye göre
        //veri çekiyoruz company tablosundan
        $contacts=Contact::orderBy('first_name','asc')->where(function($query){
            if ($companyId=request('company_id')){
                $query->where('company_id',$companyId);
            }
        })->paginate(5);

        return view('contact.index',Compact('contacts','companies'));
    }

    public function create(){

        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');
        return view('contact.create',compact('companies'));
    }

    public function store(Request $request){
        // dd($request->all());
        //dd($request->only('first_name','last_name'));
        dd($request->except('first_name','last_name'));
        
    }

    public function show($id){
        $contacts=Contact::find($id);
       return view('contact.show',Compact('contacts'));
    }
}
