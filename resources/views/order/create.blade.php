@extends('layouts.dashboard')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New Order</h3>
        </div>
        <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="exampleInputprice">Select Customer :</label>
                    <select class="form-control" name="customer_id">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->userable_id }}">{{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group row">
                    <label for="">Select Medicine :</label>
                    <select class="js-example-basic-multiple" name="medicines[]" multiple="multiple">
                        @foreach ($allMedicines as $medicine)
                            <option value="{{ $medicine->id }}">{{ $medicine->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('medicines')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="">Enter Quantites :</label>
                    <select class="js-example-basic-multiple" name="quantities[]" multiple="multiple">
                    </select>
                    @error('quantities')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="">Enter Prices In cents:</label>
                    <select class="js-example-basic-multiple" name="prices[]" multiple="multiple">
                    </select>
                    @error('prices')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group row">
                    <label for="">Enter Types :</label>
                    <select class="js-example-basic-multiple" name="types[]" multiple="multiple">
                    </select>
                    @error('types')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>


            </div>
            <!-- /.card-body -->
            {{-- // TODO --}}
            {{-- Insurance Selection , After Making Stripe and making Other Stuff  --}}
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    @if ($errors->any())
        {!! implode('', $errors->all('<span style="color: red">:message</span>')) !!}
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                tags: true,
                multiple: true,
            });
        });
    </script>

    @if ($status = session('error'))
        <script>
            Toastify({
                text: '{{ $status }}',
                duration: 3000,
                style: {
                    background: "red",
                },
            }).showToast();
        </script>
    @endif
@endsection
