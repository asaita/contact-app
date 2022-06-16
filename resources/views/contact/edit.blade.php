@extends('layouts.main')

@section('title', 'Add New | Contact App')

@section('content')

<main class="py-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-title">
              <strong>Edit Contact</strong>
            </div>           
            <div class="card-body">
              <FORM action="{{route('contact.update',$contact->id)}}" method="POST">
                @method('PUT')
                @csrf
                @include('contact._form')

              </FORM>
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
