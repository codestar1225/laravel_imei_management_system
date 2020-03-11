@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Claims Details</div>
                @if($success??'')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $success }}</strong>
                    </span>
                @endif
                <div class="card-body">
                    <form name="claim_detail" method="POST" action="{{route('submit_detail')}}" id="claim_detail" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h3><i>Product Details</i></h3>
                                <div class="form-group row">
                                    <label for="Imei" class="col-sm-6 col-form-label text-right w-100">IMEI NO:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="Imei" name="imei" value="{{$search_imei[0]->imei}}" readonly="readonly" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="brand" class="col-sm-6 col-form-label text-right w-100">BRAND:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="brand" name="brand" value="SAMSUNG" readonly="readonly" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="model" class="col-sm-6 col-form-label text-right w-100">MODEL:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="model" name="model" value="{{$search_imei[0]->model}}" readonly="readonly" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="purchase_date" class="col-sm-6 col-form-label text-right w-100">DATE OF PURCHASE:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="date" id="purchase_date" name="purchase_date"  min="2020-01-01" max="2021-03-31" value="{{$search_result[0]->purchase_date??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_coverage" class="col-sm-6 col-form-label text-right w-100">START DATE OF COVERAGE:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="date" id="start_coverage" name="start_coverage" value="{{$search_result[0]->start_coverage??''}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="purchase_invoice" class="col-sm-6 col-form-label text-right w-100">UPLOAD PURCHASE INVOICE:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control-file" type="file" id="purchase_invoice" name="purchase_invoice" accept=".pdf" >
                                        @if(count($search_result) != 0) 
                                        <small>{{pathinfo($search_result[0]->purchase_invoice)['basename']}}</small>
                                        <input type="hidden" name="purchase_invoice1" value="{{$search_result[0]->purchase_invoice}}">
                                        @else <input type="hidden" name="purchase_invoice1" value="0">
                                        @endif
                                    </div>
                                </div>
                                <h3><i>Incident Details</i></h3>
                                <div class="form-group row">
                                    <label for="incident_date" class="col-sm-6 col-form-label text-right w-100">*DATE OF INCIDENT:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="date" id="incident_date" name="incident_date" value="{{$search_result[0]->incident_date??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="incident_time" class="col-sm-6 col-form-label text-right w-100">*TIME OF INCIDENT:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="time" id="incident_time" name="incident_time" value="{{$search_result[0]->incident_time??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="incident_location" class="col-form-label text-right w-100 pb-0">*LOCATION OF INCIDENT:</label>
                                        <p id="HelpInline" class="text-right w-100" style="font-size:8px">
                                            (PLEASE INDICATE THE CITY AND STATE OF THE LOCATION)
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="incident_location" name="incident_location" value="{{$search_result[0]->incident_location??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="incident_detail" class="col-form-label text-right w-100 pb-0">*INCIDENT DETAILS</label>
                                        <label for="incident_detail" class="col-form-label text-right w-100 pt-0">(HOW IT HAPPENED):</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" id="incident_detail" rows="5" name="incident_detail">{{$search_result[0]->incident_detail??''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3><i>Customer Details</i></h3>
                                <div class="form-group row">
                                    <label for="customer_name" class="col-sm-6 col-form-label text-right w-100">*NAME OF CUSTOMER:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="customer_name" name="customer_name" value="{{$search_result[0]->customer_name??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contact_number" class="col-sm-6 col-form-label text-right w-100">*CONTACT NUMBER:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="number" id="contact_number" name="contact_number" value="{{$search_result[0]->contact_number??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email_address" class="col-sm-6 col-form-label text-right w-100">*EMAIL ADDRESS:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="email" id="email_address" name="email_address" value="{{$search_result[0]->email_address??''}}">
                                    </div>
                                </div>
                                <h3><i>Repair Details</i></h3>
                                <div class="form-group row">
                                    <label for="repair_type" class="col-sm-6 col-form-label text-right w-100">REPAIR TYPE:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="repair_type" name="repair_type" value="{{$search_result[0]->repair_type??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="repair_date" class="col-sm-6 col-form-label text-right w-100">REPAIR DATE:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="date" id="repair_date" name="repair_date" value="{{$search_result[0]->repair_date??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="repair_amount" class="col-sm-6 col-form-label text-right w-100">REPAIR AMOUNT:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="repair_amount" name="repair_amount" value="{{$search_result[0]->repair_amount??''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="charges" class="col-sm-6 col-form-label text-right w-100">LABOUR\OTHER CHARGES:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" id="charges" name="charges" value="RM 60.00" readonly="readonly" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="service_centre_location" class="col-sm-6 col-form-label text-right w-100">SERVICE CENTRE LOCATION:</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" type="text" id="service_centre_location" name="service_centre_location" value="{{$search_result[0]->service_centre_location??''}}">
                                            <option value="">Service Center location</option>
                                            @foreach($service_center_locations as $service_center_location)
                                            @if(count($search_result) == 0) <option value="{{$service_center_location->id}}">{{$service_center_location->location}}</option>
                                            @else <option value="{{$service_center_location->id}}" {{$service_center_location->id ==  $search_result[0]->service_centre_location ? 'selected' : ''}}>{{$service_center_location->location}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pre_repair_photo" class="col-sm-6 col-form-label text-right w-100">UPLOAD PRE REPAIR PHOTOS:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control-file" type="file" id="pre_repair_photo" name="pre_repair_photo" accept="image/*" >
                                        @if(count($search_result) != 0) 
                                        <small>{{pathinfo($search_result[0]->pre_repair_photo)['basename']}}</small>
                                        <input type="hidden" name="pre_repair_photo1" value="{{$search_result[0]->pre_repair_photo}}">
                                        @else <input type="hidden" name="pre_repair_photo1" value="0">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="post_repair_photo" class="col-sm-6 col-form-label text-right w-100">UPLOAD POST REPAIR PHOTOS:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control-file" type="file" id="post_repair_photo" name="post_repair_photo" accept="image/*" >
                                        @if(count($search_result) != 0) 
                                        <small>{{pathinfo($search_result[0]->post_repair_photo)['basename']}}</small>
                                        <input type="hidden" name="post_repair_photo1" value="{{$search_result[0]->post_repair_photo}}">
                                        @else <input type="hidden" name="post_repair_photo1" value="0">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="service_repair_report" class="col-sm-6 col-form-label text-right w-100">UPLOAD SERVICE REPORT:</label>
                                    <div class="col-sm-6">
                                        <input class="form-control-file" type="file" id="service_repair_report" name="service_repair_report" accepted=".pdf" >
                                        @if(count($search_result) != 0) 
                                        <small>{{pathinfo($search_result[0]->service_repair_report)['basename']}}</small>
                                        <input type="hidden" name="service_repair_report1" value="{{$search_result[0]->service_repair_report}}">
                                        @else <input type="hidden" name="service_repair_report1" value="0">
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name='admin_id' value="{{$search_result[0]->admin_id??''}}">
                            </div> 
                        </div>
                        <div class="text-center">
                            <a type="button" class="btn btn-primary text-white" id="submit">Submit</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="Confirm" tabindex="-1" role="dialog" aria-labelledby="Confirm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <strong> CONFIRM SUBMISSION?</strong>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</a>
            <button type="button" class="btn btn-primary" id="confirmyes">Yes</button>
        </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    $('#submit').click(function(e){
        date = new Date($('#purchase_date').val());
        d1   = date.getTime();
        d2   = new Date('2020-01-01').getTime(),
        d3   = new Date('2021-03-31').getTime();
        
        if($('#incident_date').val() != '' && $('#incident_time').val() != '' && $('#incident_location').val() != '' && $('#incident_detail').val() != '' && $('#customer_name').val() != '' && $('#contact_number').val() != '' && $('#email_address').val() != '')
        {
            if(isNaN(d1))
            {
                e.preventDefault();
                $('#Confirm').modal('show');
            }
            else {
                if (d1 > d2 && d1 < d3) {
                    e.preventDefault();
                    $('#Confirm').modal('show');
                }else{
                    alert("Purchase dates not allow");
                    $('#purchase_date').val(null);
                    $('#start_coverage').val(null);
                }
            }
        }
        else alert('Please input all *fields.');
    });

    $('#confirmyes').click(function(){
        console.log("ddd");
        // $('#claim_detail').submit();
        $('#claim_detail').submit();
    });

    $('#purchase_date').change(function(){
        $('#start_coverage').val($('#purchase_date').val());
    })
});

</script>
@endsection
