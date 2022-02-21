@extends('layouts.dashboard')

@section('content')
    <h1>Bevenuto {{ Auth::user()->name }}</h1>
@endsection