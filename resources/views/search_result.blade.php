@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Search Result</div>
                <input id="claimcheck" type="hidden" value="{{$claimed}}">

                <div class="card-body mt-5">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped" id="employeeListing" style="text-align:center">
                        <thead>
                            <tr>
                                <th>IMEI No</th>
                                <th>MODEL NO</th>
                                <th>PURHASE DATE</th>
                                <!-- <th>DATE OF CLAIM</th> -->
                                <th>SERVICE CENTER LOCATION</th>
                                <th>CLAIM STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="listRecords">
                            <tr>
                                <td>{{$imei??''}}</td>
                                <td>{{$search_result[0]->model??''}}</td>
                                <td>{{$search_result[0]->purchase_date??''}}</td>
                                @if(isset($search_result[0]->service_centre_location))
                                @if($search_result[0]->service_centre_location!='')
                                <td> {{DB::table('service_center_locations')->where('id', $search_result[0]->service_centre_location)->get()[0]->location}}</td>
                                @endif
                                @if($search_result[0]->service_centre_location == '') <td></td>
                                @endif
                                @else <td></td>
                                @endif
                                <td>
                                    @if($claimed == 1) Claim Filed
                                    @else No Claimed Filed
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->role < 3)
    <form id="ClaimForm" method="post" action="{{route('claimdetail')}}">
    @csrf
        <div class="modal" id="CheckClaimForm" tabindex="-1" role="dialog" aria-labelledby="CheckClaimForm" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">For SC Portal</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button> -->
            </div>
            <div class="modal-body">
                <strong> <i>Do you want to File a Claim?</i></strong>
            </div>
            <div class="modal-footer">
            <input id="claimcheck" type="hidden" name="imei" value="{{$imei}}">
                <a href="{{route('home')}}" type="button" class="btn btn-secondary">No</a>
                <button type="submit" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
    </form>
    @endif
</div>
<script>
    $(document).ready(function(){
        if($('#claimcheck').val() == 0){
            $('#CheckClaimForm').modal('show');
        }
    });
</script>
@endsection
