@extends('layouts.dashboard')


@section('content')
<h1>show</h1>


<div class="card">
  <div class="card-header">
    pharmacy Info
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col col-md-6">
        <strong class="card-title">name: </strong>
        
        <p>{{$userPharmacy->name}}</p>
        <strong class="card-title">email: </strong>
        <p>{{$userPharmacy->email}}</p>


      </div>
      <div class="col col-md-6">
        <img src="{{ URL::to('/') }}/images/{{$pharmacy->avatar}}" style="width: 300px;">
      </div>
    </div>
  </div>
</div>


<div class="card mt-5">
  <div class="card-header">
    pharmacy details Info
  </div>
  <div class="card-body">
    <strong class="card-title">area: </strong>
    <p>{{$pharmacy->area->name}}</p>
    <strong class="card-title">priority: </strong>
    <p>{{$pharmacy->priority}}</p>
    <strong class="card-title">national id: </strong>
    <p>{{$pharmacy->national_id}} </p>
  </div>
</div>


@endsection


@section('scripts')
@endsection




