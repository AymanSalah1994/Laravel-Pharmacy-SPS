@extends('layouts.dashboard')

@section('content')
<br>
<h1 class="mt-2 ms-4 text-black fw-bold">User Details</h1>

<div class="card mt-5 text-center bg-primary shadow-lg rounded-3" style="width:60%; margin:auto;">
    <img class="card-img-top" src="" alt="{{$customer->profile_image}}">
    <div class="card-body">
      <h5 class="card-title fs-3 fw-bold">{{$userCustomer->name}}</h5>
      <p class="card-text fw-bold">Personal Info:</p>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item fw-bold">NationalID: {{$customer->national_id}}</li>
      <li class="list-group-item fw-bold">Gender: {{$customer->gender}}</li>
      <li class="list-group-item fw-bold">Date of Birth: {{$customer->dob}}</li>
      <li class="list-group-item fw-bold">Mobile Number: {{$customer->mobile_number}}</li>
      <li class="list-group-item fw-bold">Last Login: {{$customer->last_login}}</li>

    </ul>
    <div class="d-flex justify-content-evenly m-3">
      <a href={{route('customers.index')}} class="btn btn-primary col-4 fw-bold" >Back</a>
      <a href={{route('customers.edit', $customer->id)}} class="btn btn-primary col-4 fw-bold" >Edit</a>
    </div>
  </div>
  @endsection

@section('scripts')
@endsection
