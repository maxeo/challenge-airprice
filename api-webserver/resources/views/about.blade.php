@extends('layout/boostrap-layout')
@section('title',$title)
@section('main-container')
       <h1>{{$title}}</h1>
    Persons are:
    <ul>
        @foreach($pesrons AS $person)
            <li @if($loop->first) style="color: #ff5100" @endif>{{$person['name']}} {{$person['surname']}}</li>
        @endforeach
    </ul>
@endsection
@section('footer')
    @parent
@endsection
@section('footer_bootstrap_for','About')
