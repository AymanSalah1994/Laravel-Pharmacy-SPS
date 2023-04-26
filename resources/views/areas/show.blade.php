@extends('layouts.dashboard')

@section('content')
    {{-- @dd($area); --}}
    <br>
    <h1 class="mt-2 ms-4 text-black fw-bold">Area Details</h1>

    <div class="card mt-5 text-center bg-primary shadow-lg rounded-3" style="width:60%; margin:auto;">
        <img class="card-img-top" src="" alt="{{$area->country->flag}}">
        <div class="card-body">
          <h2 class="card-title fs-3"><b>{{$area->country->name}}</b></h2>
          <br><br>
          <p class="card-text fw-bold">Capital: {{$area->country->capital}}</p>
          <p class="card-text fw-bold">Curruncy: {{$area->country->currency_code}}</p>
          <p class="card-text fw-bold fs-4"><u>Our users in {{$area->country->name}}:</u></p>
        </div>

        <ul class="list-group list-group-flush">
            @foreach($areas as $name)
            <li class="list-group-item">{{$name->name}}</li>
          @endforeach

        </ul>

        <div class="d-flex justify-content-evenly m-3">
          <a href={{route('areas.index')}} class="btn btn-primary col-4 fw-bold" >Back</a>
          <a href={{route('areas.edit', $area->id)}} class="btn btn-primary col-4 fw-bold" >Edit</a>
        </div>
      </div>
      <br>
@endsection

@section('scripts')
@endsection
