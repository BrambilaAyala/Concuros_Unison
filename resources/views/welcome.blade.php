@extends('layouts.app')

@section('content')
@if (session('notification'))
<div class="alert alert-success" role="alert">
    {{ session()->get('notification') }}
</div>
@endif
{{--     <a href="{{ route('send') }}">aaaaaaaaaaaaaaaaaaa</a> --}}
@endsection