@extends('radmin::layouts.master')

@guest
    @else
@section('content')
    Dashboard
@endsection
@endguest
