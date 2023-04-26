@extends('layouts.dashboard')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h2 class="card-title">Handling Order # {{ $order->id }}</h2>
        </div>
        <form method="POST" action="{{ route('orders.update', $order->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputprice"> Customer Id :</label>
                    <input type="text" class="form-control" id="exampleInputname" placeholder="Enter Name"
                        name="customer_id" value="{{ $order->customer_id }}" readonly>
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
                <button type="submit" class="btn btn-primary">Submit And Notify </button>
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
