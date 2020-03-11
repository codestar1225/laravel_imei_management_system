@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Search</div>

                <div class="card-body mt-5 mb-5">
                    <form method="POST" action="{{route('search_result')}}">
                        @csrf

                        <div class="form-group col-md-6 mr-auto ml-auto mt-5 mb-5">
                            <label for="searchinput" class="w-100 text-center">Please Input IMEI No to Begin Search</label>
                            <input type="text" class="form-control" id="searchinput" name="searchinput" placeholder="IMEI" required>
                            <div class="alert alert-dismissible fade show text-center pr-0 pt-0" style="color:red;">
                                @if($message??'')
                                <strong>{{$message}}</strong>
                                @endif
                        </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
