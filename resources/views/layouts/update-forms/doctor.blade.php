<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Doctor</h3>
    </div>
    <form method="POST" action="{{ route('doctors.update', $doctor->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name"
                    name="name" value="{{$userDR->name}}">
                    @error('name')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                    name="email" value="{{$userDR->email}}">
                    @error('email')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                    name="password" value="{{$userDR->password}}">
                    @error('password')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">National ID </label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                    name="national_id" value="{{$doctor->national_id}}">
                    @error('national_id')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Avatar Image</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="avatar_image" value="{{$doctor->avatar_image}}">
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
