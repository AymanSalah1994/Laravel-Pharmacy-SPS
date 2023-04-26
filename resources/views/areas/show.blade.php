@extends('layouts.dashboard')

@section('content')
    {{-- @dd($area); --}}
    <div class="card" style="width:60%; margin:auto;">
        <img class="card-img-top" src="" alt="{{$area->country->flag}}">
        <div class="card-body">
          <h2 class="card-title"><b>{{$area->country->name}}</b></h2>
          <br><br>
          <p class="card-text">Capital: {{$area->country->capital}}</p>
          <p class="card-text">Curruncy: {{$area->country->currency_code}}</p>
          <p class="card-text"><u>Our users in {{$area->country->name}}:</u></p>
        </div>

        <ul class="list-group list-group-flush">
            @foreach($areas as $name)
            <li class="list-group-item">{{$name->name}}</li>
          @endforeach

        </ul>

        <div class="card-body">
          <a href={{route('areas.index')}} class=\"btn btn-primary\" >Back</a>
          <a href={{route('areas.edit', $area->id)}} class=\"btn btn-primary\" >Edit</a>
        </div>
      </div>

@endsection

@section('scripts')
@endsection
