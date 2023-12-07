<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(){

        //pluck metodu veritabanından dizi şeklinde veri çekmeye yarıyor. 
        //orderby ise çekilen veriyi isime göre sıralıyor
        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');

        //DB::enableQueryLog();
        
        $query=Contact::query();

        if(request()->query('trash')){
            $query->onlyTrashed();
        }
        

        //Aşağıdan SAYFALAMA yapmamızı sağlıyor. javascript ile gelen company idye göre
        //veri çekiyoruz company tablosundan
        //$contacts=Contact::orderBy('first_name','asc')->where(function($query){ ders 108 den dolayı burayı değiştirmek zorunda kaldık
            $contacts=$query->sortByNameAlpha()->filterByCompany()->where(function ($query){

            if($search=request('search')){
                $query->where('first_name','LIKE',"%{$search}%");
                $query->orwhere('last_name','LIKE',"%{$search}%"); 
                $query->orwhere('email','LIKE',"%{$search}%");  

            }

        })->paginate(10);

        //dump(DB::getQueryLog());

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

    public function destroy($id){
       
        $contact=Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact.index')
        ->with('message',"Contact has been moved to trash")
        ->with('undoRoute',$this->getUndoRoute('contacts.restore',$contact));
        

    }

    public function restore($id){
       
        $contact=Contact::onlyTrashed()->findOrFail($id);
        $contact->restore();
        $redirect=request()->query('redirect');

        return ($redirect ? redirect()->route($redirect):back())
        ->with('message','Contact has been restored from trash')
        ->with('undoRoute',$this->getUndoRoute('contacts.destroy',$contact));
        

    }

    protected function getUndoRoute($name, $resource){

            return request()->missing('undo')?route($name,[$resource->id,'undo'=>true]):null;

    }

    public function forceDelete($id){
       
        $contact=Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();

        return back()
        ->with('message',"Contact has been removed permanently");

    }
}
