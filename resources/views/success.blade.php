@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Success</div>

                <div class="card-body m-5 text-center">

                    @if($success??'')
                    <div class="alert alert-success alert-dismissible fade show mr-5 ml-5">
                        <strong>{{$success}}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
