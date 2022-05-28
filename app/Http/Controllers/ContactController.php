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
        $companies=Company::orderby('name')->pluck('name','id')->all();

        // $contacts = Contact::all();
        //aşağıdaki satır üstdeki satırdan farklı olarak isim sütununu a den z ye doğru sıralıyor
        //$contacts=Contact::orderBy('first_name','asc')->get();

        //Aşağıdan SAYFALAMA yapmamızı sağlıyor
        $contacts=Contact::orderBy('first_name','asc')->paginate(5);

        return view('contact.index',Compact('contacts','companies'));
    }

    public function create(){
        return view('contact.create');
    }

    public function show($id){
        $contact=Contact::find($id);
        return view('contact.show', compact('contact','companies'));
    }
}
