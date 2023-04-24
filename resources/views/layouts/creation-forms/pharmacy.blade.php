<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Create Pharmacy</h3>
    </div>
    <form method="POST" action="{{ route('pharmacies.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name"
                    name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                    name="email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                    name="password">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">National ID </label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                    name="national_id">
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Area ID </label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                        name="area_id">
                </div>
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Priority</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                        name="priority">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Avatar Image</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="avatar_image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
