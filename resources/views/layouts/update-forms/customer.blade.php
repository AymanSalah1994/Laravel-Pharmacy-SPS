<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title fw-bold fs-4">Update User Data</h3>
    </div>
    <form method="POST" action="{{ route('customers.update', $cust ) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-6">
                    <label for="nameLab">Name</label>
                    <input type="text" class="form-control" id="nameLab" placeholder="Enter Name" name="name"
                        value="{{ $cust->users[0]->name }}">
                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                        name="email" value="{{ $cust->users[0]->email }}">
                    @error('email')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="natio">National ID</label>
                    <input type="text" class="form-control" id="natio" placeholder="Enter ID" name="national_id"
                        value="{{ $cust->national_id }}">
                    @error('national_id')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="dobN">Date Of Birth</label>
                    <input type="text" class="form-control" id="dobN" placeholder="Enter DOB" name="dob"
                        value="{{ $cust->dob }}">
                    @error('dob')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="gen">Gender</label>
                    <input type="text" class="form-control" id="gen" placeholder="Enter Gender" name="gender"
                        value="{{ $cust->gender }}">
                    @error('gender')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="mob">Mobile Number</label>
                    <input type="text" class="form-control" id="mob" placeholder="Enter Mobile"
                        name="mobile_number" value="{{ $cust->mobile_number }}">
                    @error('mobile_number')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary fw-bold">Submit</button>
        </div>
    </form>
</div>
