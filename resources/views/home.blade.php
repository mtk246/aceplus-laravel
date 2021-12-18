@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <ul class="list-group list-group-horizontal" style="width: 100%; overflow: auto">
                <li class="list-group-item">
                    <a href="{{ route('company') }}" class="btn text-primary">Companies</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('employee') }}" class="btn text-primary">Employees</a>
                </li>
            </ul>
        </div>
    </div>

    {{-- <div class="container-fluid mt-3 p-5 rounded-3" style="background-color: #ececec;">
        <h1 class="display-5 text-primary fw-bolder">Company Information Form</h1>
        <form action="{{ route('companyv1') }}" method="POST">
            @csrf

            @include('layouts.company')
        </form>
    </div> --}}
</div>
@endsection
