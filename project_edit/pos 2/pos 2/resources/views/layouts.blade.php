<!doctype html>

<html>

<head>
    @include('components.head')


</head>

@include('components.header')

@include('components.sidebar')
@include('components.wrapper')
@yield('content')
@include('components.footer')
