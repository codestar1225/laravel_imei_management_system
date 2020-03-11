@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">IMEI Information</div>
                <form class="form-inline m-4" action="{{route('search_imei')}}" method="post">
                @csrf
                    <div class="col-sm-1 pr-0">
                        <label for="datesearch" class="col-form-label">Date:</label>
                    </div>
                    
                    <div class="col-sm-2 mr-3 pl-0">
                        <input type ="date" class="form-control" id="date1" name="fromdate" placeholder="From Date">
                    </div>
                    <div class="col-sm-2 mr-3 pl-0">
                        <input type ="date" class="form-control" id="date2" name="todate" placeholder="To Date">
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="service_center_location" style="max-width:100%;">
                            <option value="">Service Center location</option>
                            @foreach($service_center_locations as $service_center_location)
                                <option value="{{$service_center_location->id}}">{{$service_center_location->location}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check col-sm-2 pr-0">
                        <label class="radio-inline col-sm-6 pl-0"><input type="radio" name="claimed" value="1">Claimed</label>
                        <label class="radio-inline col-sm-6 p-0"><input type="radio" name="claimed" value="0">No Claimed</label>
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    
                </form>
                <div class="card-body mt-3 table-responsive">

                    <table id="imei_detail" class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>IMEI</th>
                                <th>BRAND</th>
                                <th>MODEL</th>
                                <th>DATE OF PURCHASE</th>
                                <th>START DATE OF COVERAGE</th>
                                <th>UPLOAD PURCHASE INVOICE</th>
                                <th>DATE OF INCIDENT</th>
                                <th>TIME OF INCIDENT</th>
                                <th>LOCATION OF INCIDENT</th>
                                <th>INCIDENT DETAILS</th>
                                <th>NAME OF CUSTOMER</th>
                                <th>CONTACT NUMBER</th>
                                <th>EMAIL ADDRESS</th>
                                <th>REPAIR TYPE</th>
                                <th>REPAIR DATE</th>
                                <th>REPAIR AMOUNT</th>
                                <th>LABOUR\OTHERS CHARGES</th>
                                <th>SERVICE CENTRE LOCATION</th>
                                <th>UPLOAD PRE REPAIR PHOTOS</th>
                                <th>UPLOAD POST REPAIR PHOTOS</th>
                                <th>UPLOAD SERVICE REPORT</th>
                                <th>CLAIM STATUS</th>
                                @if(Auth::user()->role <= 1)
                                <th>ACTION</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $index=>$each)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$each->imei}}</td>
                                <td>{{$each->brand??''}}</td>
                                <td>{{$each->model??''}}</td>
                                <td>{{$each->purchase_date??''}}</td>
                                <td>{{$each->start_coverage??''}}</td>
                                <td style="word-break: break-all;"><a href="{{url($each->purchase_invoice??'')}}" download>{{pathinfo($each->purchase_invoice??'')['basename']}}</a></td>
                                <td>{{$each->incident_date??''}}</td>
                                <td>{{$each->incident_time??''}}</td>
                                <td>{{$each->incident_location??''}}</td>
                                <td>{{$each->incident_detail??''}}</td>
                                <td>{{$each->customer_name??''}}</td>
                                <td>{{$each->contact_number??''}}</td>
                                <td>{{$each->email_address??''}}</td>
                                <td>{{$each->repair_type??''}}</td>
                                <td>{{$each->repair_date??''}}</td>
                                <td>{{$each->repair_amount??''}}</td>
                                <td>{{$each->charges??''}}</td>
                                @if($each->service_centre_location)
                                @if(isset(DB::table('service_center_locations')->where('id', $each->service_centre_location)->get()[0]))
                                <td> {{DB::table('service_center_locations')->where('id', $each->service_centre_location)->get()[0]->location}}</td>
                                @else <td></td>
                                @endif
                                @endif
                                @if(!$each->service_centre_location) <td></td>
                                @endif
                                <td style="word-break: break-all;"><a href="{{url($each->pre_repair_photo??'')}}" download>{{pathinfo($each->pre_repair_photo??'')['basename']}}</a></td>
                                <td style="word-break: break-all;"><a href="{{url($each->post_repair_photo??'')}}" download>{{pathinfo($each->post_repair_photo??'')['basename']}}</a></td>
                                <td style="word-break: break-all;"><a href="{{url($each->service_repair_report??'')}}" download>{{pathinfo($each->service_repair_report??'')['basename']}}</a></td>
                                <td>
                                    @if($each->claimed == 1) Claim Filed
                                    @else No Claimed Filed
                                    @endif
                                </td>
                                @if(Auth::user()->role <= 1)
                                <td>
                                    <a href="{{url('/edit_imei/'.$each->imei)}}" class="btn btn-info btn-sm editImei mb-1" data-id="{{$each->imei}}" style="color:white; width:55px;">Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteImei" data-id="{{$each->imei}}" style="width:55px;">Delete</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form id="deleteImeiForm" method="post" action="{{route('delete_imei')}}">
    @csrf
        <div class="modal fade" id="deleteImeiModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete IMEI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>Are you sure to delete this IMEI?</strong>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="deleteImeiId" id="deleteImeiId" class="form-control">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {

    $('.deleteImei').on('click', function(){
        console.log('ddd');
        var id = $(this).data('id');
        $('#deleteImeiModal').modal('show');
        $('#deleteImeiId').val(id);
    });

    $('#imei_detail').DataTable( {
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        dom: 'lBfrtip',
        filter:false,
        "scrollX": true,
        buttons: [
            {
                extend: 'excel',
                text: 'EXPORT',
                exportOptions: {
                    columns: [ 1, 2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                }
            }
        ],
        select: true
    } );

} );
</script>
@endsection
