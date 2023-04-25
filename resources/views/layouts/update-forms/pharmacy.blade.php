<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Pharmacy</h3>
    </div>
    <form method="POST" action="{{ route('pharmacies.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" class="form-control" name="id" id="exampleFormControlInput1" value="{{$pharmacy->id}}" hidden >
        <input type="text" class="form-control" name="userable_id" id="exampleFormControlInput1" value="{{$userPharma->userable_id}}" hidden >

        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name"
                    name="name" value="{{ $userPharma->name }}" >
                    @error('name')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror 
            </div>
           
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                    name="email" value="{{ $userPharma->email }}">
                    @error('email')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror 
            </div>


            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                    name="password" value="{{ $userPharma->password}}">
                    @error('password')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror 
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">National ID </label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                    name="national_id" value="{{ $pharmacy->national_id}}">
                    @error('national_id')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror 
            </div>
         
            <div class="row">
            @if(Auth::user()->hasRole('admin'))
            

                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Area</label>
                    <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Area ID"
                        name="area_id" value="{{ $pharmacy->area->name}}"> -->
                        <select name="area_id" class="form-control" value="@if($pharmacy->area!=null){{$pharmacy->area->name}}  @else Not Found   @endif">
             @if($pharmacy->area==null )
            <option selected >Not Found</option>
            @endif

                @foreach($areas as $area)
                @if($pharmacy->area!=null && $pharmacy->area->name== $area->name  )
                <option value="{{$area->id}}" selected >{{$area->name}}</option>
                @else
                    <option value="{{$area->id}}">{{$area->name}}</option>

                @endif
                @endforeach
            </select>
                  
                </div>
             
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Priority</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" 
                        name="priority"value="{{ $pharmacy->priority}}">
                        @error('priority')
                        <p class="text-danger mt-1">{{ $message }}</p>
                          @enderror 
                </div>
            </div>
           

            @else
            <div class="form-group col-6">
                    <label for="exampleInputEmail1">Area</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Area ID"
                        name="area_id" value="{{ $pharmacy->area->id}}" hidden>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Area ID"
                        name="area_id" value="{{ $pharmacy->area->name}}" disabled>
                        @error('area_id')
                        <p class="text-danger mt-1">{{ $message }}</p>
                          @enderror 
                </div>
             
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Priority</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" 
                        name="priority" value="{{ $pharmacy->priority}}" hidden>
                    <input type="text" class="form-control" id="exampleInputEmail1" 
                        name="priority" value="{{ $pharmacy->priority}}" disabled>
                        @error('priority')
                        <p class="text-danger mt-1">{{ $message }}</p>
                          @enderror 
                </div>
            </div>

            @endif
         
                
            <div class="form-group">
                <label for="exampleInputFile">Avatar Image</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="avatar_image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        @error('avatar_image')
                        <p class="text-danger mt-1">{{ $message }}</p>
                          @enderror 
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