@extends('layouts.dashboard')

@section('content')
<br>
<h1 class="mt-2 ms-4 text-black fw-bold">Doctor Details</h1>

<div class="card mt-5 text-center bg-primary shadow-lg rounded-3" style="width:60%; margin:auto;">
  <img class="card-img-top" src="" alt="{{$doctor->avatar_image}}">
  <div class="card-body">
    <h5 class="card-title fs-4 fw-bold">DR: {{$userDR->name}}</h5>
    <p class="card-text fw-bold pt-3">Personal Info:</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item fw-bold">for-contact: {{$userDR->email}}</li>
    <li class="list-group-item fw-bold">National ID: {{$doctor->national_id}}</li>
    <li class="list-group-item fw-bold">Banned:
  @if($doctor->is_banned == 0)
   <span class="text-success">Not banned</span>
  @else
  <span class="text-danger">Banned</span>
  @endif
</li>
  </ul>
  <div class="d-flex justify-content-evenly m-3">
    <a href={{route('doctors.index')}} class="btn btn-primary col-4 fw-bold" >Back</a>
    <a href={{route('doctors.edit', $doctor->id)}} class="btn btn-primary col-4 fw-bold" >Edit</a>
  </div>
</div>
@endsection

@section('scripts')
@endsection
