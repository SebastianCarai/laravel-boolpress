@extends('layouts.dashboard')

@section('content')
    <h1>Bevenuto {{ $user->name }}</h1>

    @if ($userInfo)
        <h4>Phone number: {{$userInfo->phone_number}}</h4>
        <h4>Address: {{$userInfo->address}}</h4>
    @endif
@endsection