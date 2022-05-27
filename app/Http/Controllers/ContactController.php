<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
       // $contacts = Contact::all();
       //aşağıdaki satır üstdeki satırdan farklı olarak isim sütununu a den z ye doğru sıralıyor
        //$contacts=Contact::orderBy('first_name','asc')->get();

        //Aşağıdan SAYFALAMA yapmamızı sağlıyor
        $contacts=Contact::orderBy('first_name','asc')->paginate(5);
        return view('contact.index',Compact('contacts'));
    }

    public function create(){
        return view('contact.create');
    }

    public function show($id){
        $contact=Contact::find($id);
        return view('contact.show', compact('contact'));
    }
}
