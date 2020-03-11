@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Information</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button class="btn btn-success" data-toggle="modal" data-target="#addEmpModal"><i class="glyphicon glyphicon-plus"></i> Add User</button>
                    <br></br>
                    <table id="table-payouts" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="listRecords">
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{++$index}}</td>
                                <td>{{$user->username}}</td>
                                <td>***************</td>
                                @if(Auth::user()->role == 1)
                                <td>
                                    @if($user->role == 2) service center
                                    @elseif($user->role == 3) sales person
                                    @endif
                                </td>
                                @else
                                <td>admin</td>
                                @endif
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-info btn-sm editUser" data-id="{{$user->id}}" data-username="{{$user->username}}" data-password="{{$user->password}}" data-role="{{$user->role}}">Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteUser" data-id="{{$user->id}}">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form id="saveEmpForm" method="post" action="{{route('adduser')}}">
    @csrf
        <div class="modal fade" id="addEmpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">x</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Username</label>
                            <div class="col-md-10">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                                
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Role</label>
                            <div class="col-md-10">
                                <select name="role" id="role" class="form-control">
                                    @if(Auth::user()->role == 0)
                                    <option value="1" selected>admin</option>
                                    @else
                                    <option value="2">service center</option>
                                    <option value="3">sales person</option>
                                    @endif
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
    <form id="editUserForm" method="post" action="{{route('edituser')}}">
    @csrf
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Username</label>
                        <div class="col-md-10">
                        <input type="text" name="editusername" id="editusername" class="form-control" required>
                        </div>
                    </div>              
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                        <input type="password" name="editpassword" id="editpassword" class="form-control" placeholder="Input New Password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Role</label>
                        <div class="col-md-10">
                            <select name="editrole" id="role" class="form-control">
                                    @if(Auth::user()->role == 0)
                                    <option value="1" selected>admin</option>
                                    @else
                                    <option value="2">service center</option>
                                    <option value="3">sales person</option>
                                    @endif
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
    <form id="deleteUserForm" method="post" action="{{route('deleteuser')}}">
    @csrf
        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>Are you sure to delete this User?</strong>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="deleteUserId" id="deleteUserId" class="form-control">
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
        $('.editUser').on('click', function(){
            console.log('ddd');
            var id = $(this).data('id');
            var username = $(this).data('username');
            var password = $(this).data('password');
            var role = $(this).data('role');
            $('#editUserModal').modal('show');    
            $('[name="editid"]').val(id);
            $('[name="editusername"]').val(username);
            $('[name="editrole"]').val(role);
        });

        $('.deleteUser').on('click', function(){
            var id = $(this).data('id');
            $('#deleteUserModal').modal('show');
            $('[name="deleteUserId"]').val(id);
        });
        
        $('#table-payouts').DataTable();
        // $('#table-payouts tbody').show();
    });
    
</script>
@endsection
