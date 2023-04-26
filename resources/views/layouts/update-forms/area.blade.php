<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Area</h3>
    </div>
    <form method="POST" action="{{ route('areas.update', $ar->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputname">Name : </label>
                <input type="text" class="form-control" id="exampleInputname" placeholder="Enter Area Name"
                    name="name"  value="{{ $ar->name }}">
                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputprice">Select Country :</label>
                <select class="form-control" name="country_id">
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            @if ($country->id == $ar->country_id) {{ 'selected' }} @endif>{{ $country->full_name }}
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
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
