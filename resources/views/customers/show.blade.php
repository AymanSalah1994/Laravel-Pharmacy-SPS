@extends('layouts.dashboard')

@section('content')
<div class="card" style="width:60%; margin:auto;">
    <img class="card-img-top" src="" alt="{{$customer->profile_image}}">
    <div class="card-body">
      <h5 class="card-title">{{$userCustomer->name}}</h5>
      <p class="card-text">Personal Info:</p>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">NationalID: {{$customer->national_id}}</li>

    </ul>
    <div class="card-body">
      <a href={{route('customers.index')}} class=\"btn btn-primary\" >Back</a>
      <a href={{route('customers.edit', $customer->id)}} class=\"btn btn-primary\" >Edit</a>
    </div>
  </div>
  @endsection

@section('scripts')
@endsection
