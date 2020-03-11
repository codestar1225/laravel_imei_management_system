<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Import Excel</div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ url('import-excel') }}" method="POST" name="importform" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="import_file" class="form-control">
                        <br>
                        <button class="btn btn-success">Import File</button>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Data</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Document Date</th>
                                <th>Product</th>
                                <th>Model</th>
                                <th>IMEI</th>
                            </tr>
                            @foreach($imeis as $c)
                            <tr>
                                <td>{{ $c->document_date }}</td>
                                <td>{{ $c->product }}</td>
                                <td>{{ $c->model }}</td>
                                <td>{{ $c->imei }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>