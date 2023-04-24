<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Update Customer</h3>
    </div>
    <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputname">Name : </label>
                <input type="text" class="form-control" id="exampleInputname" placeholder="Enter Name" name="name"
                    value="{{ $cust->users[0]->name }}">
                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputprice">price in Cents :</label>
                <input type="text" class="form-control" id="exampleInputprice" placeholder="Enter Price"
                    name="price" value="{{ $cust->dob }}">
                @error('price')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
