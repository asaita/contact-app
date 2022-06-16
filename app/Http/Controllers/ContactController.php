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

        $contact = new Contact();
        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');
        return view('contact.create',compact('companies','contact'));
    }

    public function edit($id)
    {
        $contact=Contact::findOrFail($id); 
        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');
        return view('contact.edit',compact('companies','contact'));
    }

    public function store(Request $request){

        //validate laravel fonksiyonu hangi alanda hangi doğrulamarı yapmamız gerektiğini belirtiyoruz
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
            'address'=>'required',
            'company_id'=>'required|exists:companies,id'
        ]);
        
        // dd($request->all());
        //dd($request->only('first_name','last_name'));
        //ekranda diziyi düzgün bir şekilde görmemizi sağlıyo
        //dd($request->except('first_name','last_name'));

        //formdaki verileri veritabanına ekledi bu verileri form idye göre alıyor
        Contact::create($request->all());

        return redirect()->route('contact.index')->with('message',"Contact hasbeen added succesfully");
        
    }

    public function update($id, Request $request){

        
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
            'address'=>'required',
            'company_id'=>'required|exists:companies,id'
        ]);
        
        
        $contact=Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('contact.index')->with('message',"Contact hasbeen updated succesfully");
        
    }

    public function show($id){
        $contacts=Contact::findOrFail($id);
       return view('contact.show',Compact('contacts'));
    }
}
