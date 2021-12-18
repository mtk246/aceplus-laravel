@extends('layouts.app')

@section('content')
@php
$json = json_encode($response->json());
$decoded = json_decode($json);
print_r($decoded);
@endphp
{{-- @foreach ($decoded as $d)
<p>{{ $d->name }}</p>
@endforeach --}}
@endsection
