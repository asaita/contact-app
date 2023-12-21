@extends('layouts.main')

@section('title', 'All Contacts | Contact App')

@section('content')
<main class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header card-title">
                <div class="d-flex align-items-center">
                  <h2 class="mb-0">
                    All Contacts
                    @if (request()->query('trash'))
                        <small>(In Trash)</small>
                    @endif
                  </h2>
                  <div class="ml-auto">
                    <a href="{{route('contact.create')}}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
                  </div>
                </div>
              </div>
            <div class="card-body">
              @include('contact._filter')
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">
                      {!! sortable("First Name","first_name") !!}
                    </th>
                    <th scope="col">
                      {!! sortable("Last Name","last_name") !!}
                    </th>
                    <th scope="col">
                      {!! sortable("Email","email") !!}
                    </th>
                    <th scope="col">Company</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>

                  @php
                   $showTrashButtons= request()->query('trash') ? true :false;
                  @endphp

                  @if ($message = session('message'))
                    <div class="alert alert-success">{{$message}}
                    
                      @if ($undoRoute=session('undoRoute'))

                        <form action="{{$undoRoute}}" method="POST" style="display: inline">
                          @csrf
                          @method('delete')
                          <button class="btn alert-link">Undo</button>
                        </form>

                      @endif
                    </div>
                  @endif
                  
                    @if ($contacts->count())

                      @foreach ($contacts as $index=>$contact)

                      <tr>
                        <th scope="row">{{$index+$contacts->firstItem() }}</th>
                        <!-- mesela 100 kayıt olsaydı 10 lu sayfalamadan 
                          ilk sayfada 1 2.sayfada 11 3.sayfada 22 olacaktı firsitem değeri -->
                        {{-- <td>{{$contacts->firstItem()}}</td> --}}
                        <td>{{$contact->first_name}}</td>
                        <td>{{$contact->last_name}}</td>
                        <td>{{$contact->email}}</td>
                        <td>{{$contact->Company->name}}</td>
                        <td width="150">

                          @if ($showTrashButtons)

                            <form id="form-delete" action="{{route('contacts.restore',$contact->id)}}" method="POST" style="display: inline">  
                              @csrf
                              @method('delete')
                              
                              <button class="btn btn-sm btn-circle btn-outline-info" type="submit" title="Restore"><i class="fa fa-undo"></i></button>
                            </form>
                            <form id="form-delete" action="{{route('contacts.forceDelete',$contact->id)}}" onsubmit="return confirm('Your data will be removed permanently. Are you sure?') " method="POST" style="display: inline">  
                              @csrf
                              @method('delete')
                              
                              <button class="btn btn-sm btn-circle btn-outline-danger" type="submit" title="Delete permanently"><i class="fa fa-times"></i></button>
                            </form>
                              
                          @else
                              
                            <a href="{{route('contact.show', $contact->id)}}" class="btn btn-sm btn-circle btn-outline-info" title="Show"><i class="fa fa-eye"></i></a>
                            <a href="{{route('contact.edit',$contact->id)}}" class="btn btn-sm btn-circle btn-outline-secondary" title="Edit"><i class="fa fa-edit"></i></a>
                            <form id="form-delete" action="{{route('contacts.destroy',$contact->id)}}" method="POST" style="display: inline">  
                              @csrf
                              @method('delete')
                              
                              <button class="btn btn-sm btn-circle btn-outline-danger" type="submit" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                      
                    @endif
                    
                  </tr>
                </tbody>
              </table> 
              {{-- pagination linkleri 1,2,3,4 --}}
              {{$contacts->appends(request()->only('company_id'))->links()}}
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>


@endsection

