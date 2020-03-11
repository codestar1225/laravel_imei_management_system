@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Service Center Location</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button class="btn btn-success" data-toggle="modal" data-target="#addEmpModal"><i class="glyphicon glyphicon-plus"></i> Add Location</button>
                    <br></br>
                    <table id="table-payouts" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Service Center Location</th>
                                <th>Admin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="listRecords">
                            @foreach($service_centers as $index => $service_center)
                            <tr>
                                <td>{{++$index}}</td>
                                <td>{{$service_center->location}}</td>
                                <td>{{DB::table('users')->where('id', $service_center->admin_id)->get()[0]->username}}</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-info btn-sm editLocation" data-id="{{$service_center->id}}" data-location="{{$service_center->location}}" data-admin_id="{{$service_center->admin_id}}">Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteLocation" data-id="{{$service_center->id}}">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form id="saveLocationForm" method="post" action="{{route('add_location')}}">
    @csrf
        <div class="modal fade" id="addEmpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Service Center Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">x</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Location</label>
                            <div class="col-md-10">
                                <input type="text" name="location" id="location" class="form-control" placeholder="Location" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Asign to Admin</label>
                            <div class="col-md-10">
                                <select name="admin_id" id="admin_id" class="form-control">
                                    @foreach($admins as $admin)
                                    <option value="{{$admin->id}}">{{$admin->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </form>
    <form id="editLocationForm" method="post" action="{{route('edit_location')}}">
    @csrf
        <div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Sevice Center Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Location</label>
                    <div class="col-md-10">
                    <input type="text" name="editlocation" id="editlocation" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Asign to Admin</label>
                    <div class="col-md-10">
                        <select name="editadmin_id" id="editadmin_id" class="form-control">
                            @foreach($admins as $admin)
                            <option value="{{$admin->id}}">{{$admin->username}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>              
            </div>
            <div class="modal-footer">
                <input type="hidden" name="editid" id="editid" class="form-control">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </div>
        </div>
        </div>
    </form>
    <form id="deleteLocationForm" method="post" action="{{route('delete_location')}}">
    @csrf
        <div class="modal fade" id="deleteLocationModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>Are you sure to delete this Location?</strong>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="deleteLocationId" id="deleteLocationId" class="form-control">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
    </form>
</div>


<script>
    $(document).ready(function(){
        $('.editLocation').on('click', function(){
            var id = $(this).data('id');
            var location = $(this).data('location');
            var admin_id = $(this).data('admin_id');
            $('#editLocationModal').modal('show');    
            $('[name="editid"]').val(id);
            $('[name="editlocation"]').val(location);
            $('[name="editadmin_id"]').val(admin_id);
        });

        $('.deleteLocation').on('click', function(){
            var id = $(this).data('id');
            $('#deleteLocationModal').modal('show');
            $('[name="deleteLocationId"]').val(id);
        });
        
        $('#table-payouts').DataTable();
        // $('#table-payouts tbody').show();
    });
    
</script>
@endsection
