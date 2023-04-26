@extends('layouts.dashboard')


@section('content')
<br>
<h1 class="mt-2 ms-4 text-black fw-bold">Pharmacy Details</h1>


<div class="card mt-5 text-center bg-primary shadow-lg rounded-3">
  <div class="card-header fw-bolder fs-2">
    pharmacy Info
  </div>
  <div class="card-body">
    <div class="row d-flex align-items-center">
      <div class="col col-md-6">
        <strong class="card-title fw-bold fs-4">name: </strong>
        <p class="fw-bold fs-5">{{$userPharmacy->name}}</p>
        <strong class="card-title fw-bold fs-4">email: </strong>
        <p class="fw-bold fs-5">{{$userPharmacy->email}}</p>


      </div>
      <div class="col col-md-6">
        <img src="{{ URL::to('/') }}/images/{{$pharmacy->avatar}}" style="width: 300px;">
      </div>
    </div>
  </div>
</div>


<div class="card mt-5 text-center bg-primary shadow-lg rounded-3">
  <div class="card-header fw-bolder fs-2">
    Pharmacy Details Info
  </div>
  <div class="card-body">
    <strong class="card-title fs-5 fw-bold">area:  </strong>
    @if($pharmacy->area)
        <p class="fw-bold fs-5">{{$pharmacy->area->name}}</p>
    @else
        <p class="fw-bold"> Not registered yet</p>
    @endif
    <strong class="card-title fs-5 fw-bold">priority: </strong>
    <p class="fw-bold">{{$pharmacy->priority}}</p>
    <strong class="card-title fs-5 fw-bold">national id: </strong>
    <p class="fw-bold ">{{$pharmacy->national_id}} </p>
  </div>
  <div class="d-flex justify-content-evenly m-3 ">
    <a href="{{route('pharmacies.edit',$pharmacy->id)}}" class="btn btn-primary col-4 fw-bold">Edit</a>
    @if (Auth::user()->role == 'admin')
    <a href="{{route('pharmacies.index')}}" class="btn btn-primary col-4 fw-bold">Back</a>
    @else
    <a href="/pharmacies" class="btn btn-primary col-4 fw-bold">Back</a>
    @endif
    </div>
</div>



@endsection


@section('scripts')
@endsection




