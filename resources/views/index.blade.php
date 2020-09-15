@extends('layouts.default')

@section('page_title', __('Home'))

@section('content')
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <inspection-component/>
                </div>
            </div>
        </div>
    </div>
@endsection
