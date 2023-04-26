<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title fw-bold fs-4">Create New Area</h3>
    </div>
    <form method="POST" action="{{ route('areas.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputname">Name : </label>
                <input type="text" class="form-control" id="exampleInputname" placeholder="Enter Area Name"
                    name="name">
                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputprice">Select Country :</label>
                <select class="form-control" name="country_id">
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            @if ($country->id == 818) {{ 'selected' }} @endif>{{ $country->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('countryID')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary fw-bold">Submit</button>
        </div>
    </form>
</div>
