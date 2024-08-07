<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index(){

        //pluck metodu veritabanından dizi şeklinde veri çekmeye yarıyor. 
        //orderby ise çekilen veriyi isime göre sıralıyor
        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');

        //DB::enableQueryLog();
        
        
        $contacts=Contact::allowedTrash()->allowedSorts(['first_name','last_name','email'],"-id")
        ->allowedFilters('company_id')
        ->allowedSearch('first_name','last_name','email')
        ->paginate(10);

        //dump(DB::getQueryLog());

        return view('contacts.index',Compact('contacts','companies'));
    }

    public function create(){

        $contact = new Contact();
        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');
        return view('contacts.create',compact('companies','contact'));
    }

    public function edit(Contact $contact)
    {
        //$contact=Contact::findOrFail($id); fonksiyonun içine id yerine Contact $contact yazdık ders 121

        $companies=Company::orderby('name')->pluck('name','id')->prepend('All Companies','');
        return view('contacts.edit',compact('companies','contact'));
    }

    public function store(ContactRequest $request){

        //validate ContactRequest Sınıfı ile yaptık
        
        // dd($request->all());
        //dd($request->only('first_name','last_name'));
        //ekranda diziyi düzgün bir şekilde görmemizi sağlıyo
        //dd($request->except('first_name','last_name'));

        //formdaki verileri veritabanına ekledi bu verileri form idye göre alıyor
        Contact::create($request->all());

        return redirect()->route('contacts.index')->with('message',"Contact has been added succesfully");
        
    }

    public function update($id, ContactRequest $request){

        
       
        
        
        $contact=Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('message',"Contact hasbeen updated succesfully");
    }

    public function show(Contact $contact){
        //$contacts=Contact::findOrFail($id);
       
       return view('contacts.show',Compact('contacts'));
    }

    public function destroy(Contact $contact){
       
        //$contact=Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')
        ->with('message',"Contact has been moved to trash")
        ->with('undoRoute',$this->getUndoRoute('contacts.restore',$contact));
        

    }

    public function restore(Contact $contact){
       
        //implicint binding yaptığımız için kaldırdık ders 122
        //$contact=Contact::onlyTrashed()->findOrFail($id);
        $contact->restore();
        $redirect=request()->query('redirect');

        return ($redirect ? redirect()->route($redirect):back())
        ->with('message','Contact has been restored from trash')
        ->with('undoRoute',$this->getUndoRoute('contacts.destroy',$contact));
        

    }

    protected function getUndoRoute($name, $resource){

            return request()->missing('undo')?route($name,[$resource->id,'undo'=>true]):null;

    }

    public function forceDelete(Contact $contact){
       
        //implicint binding yaptığımız için kaldırdık ders 122
        //$contact=Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();

        return back()
        ->with('message',"Contact has been removed permanently");

    }
}
