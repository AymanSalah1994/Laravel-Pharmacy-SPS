@extends('layouts.dashboard')

@section('content')
<br>
<div class="card mt-5 text-center bg-primary shadow-lg rounded-3" style="width:60%; margin:auto;">
    <div class="card-body bg-primary">
      <h5 class="card-title fw-bolder text-center fs-4">Medicine </h5>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item fs-5">{{$medicine->name}}</li>
      <li class="list-group-item fw-bolder">Price: {{$medicine->price}}</li>
    </ul>
    <div class="d-flex justify-content-evenly m-3 ">
      <a href={{route('medicines.index')}} class="btn btn-primary col-4 fw-bold" >Back</a>
      <a href={{route('medicines.edit', $medicine->id)}} class="btn btn-primary col-4 fw-bold" >Edit</a>
</div>
  </div>@endsection

@section('scripts')
@endsection
