<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Create New Medicine</h3>
    </div>
    <form method="POST" action="{{ route('medicines.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputname">Name : </label>
                <input type="text" class="form-control" id="exampleInputname" placeholder="Enter Name" name="name">
                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputprice">price in Cents :</label>
                <input type="text" class="form-control" id="exampleInputprice" placeholder="Enter Price"
                    name="price">
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
