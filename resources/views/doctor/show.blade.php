@extends('layouts.dashboard')

@section('content')
<div class="card" style="width:60%; margin:auto;">
  <img class="card-img-top" src="" alt="{{$doctor->avatar_image}}">
  <div class="card-body">
    <h5 class="card-title">DR: {{$userDR->name}}</h5>
    <p class="card-text">Personal Info:</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">for-contact: {{$userDR->email}}</li>
    <li class="list-group-item">NationalID: {{$doctor->national_id}}</li>
    <li class="list-group-item">Banned: 
  @if($doctor->is_banned == 0)
    Not banned
  @else
    Banned
  @endif
</li>
  </ul>
  <div class="card-body">
    <a href={{route('doctors.index')}} class=\"btn btn-primary\" >Back</a>
    <a href={{route('doctors.edit', $doctor->id)}} class=\"btn btn-primary\" >Edit</a>
  </div>
</div>
@endsection

@section('scripts')
@endsection
