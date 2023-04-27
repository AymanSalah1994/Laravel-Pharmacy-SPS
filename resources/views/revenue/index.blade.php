@extends('layouts.dashboard')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Pharmacy Name</th>
                <th scope="col">Total Orders</th>
                <th scope="col">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allRevenues as $revenue)
                <tr>
                    <td>{{ $revenue->PharmacyName }}</td>
                    <td>{{ $revenue->totalOrders }}</td>
                    <td>{{ $revenue->totalPrices }}$</td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection

@section('scripts')
    <script></script>
@endsection
