@extends('layouts.dashboard')

@section('content')
<p class="fw-bold bg-primary fs-4 p-2 d-flex justify-content-center mb-3">User Addresses List</p>

    <br>
    <form action="" method="" class="mb-3">
        <input type="text" name="searchkeyword" id="myBox">
    </form>
    <table class="table table-bordered yajra-datatable" id="displayingTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Main Area ID</th>
                <th>Customer Id </th>
                <th>Street Name</th>
                <th>Building Number</th>
                <th>Floor Number</th>
                <th>Flat Number</th>
                <th>IS Main</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyid">
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        function myFunction(formId, formToken) {
            let result = confirm("Are you Sure you Want to Delete This Area ? ");
            console.log(result);
            if (result) {
                let form = document.getElementById(formId);
                // form.submit();
                $.ajax({
                    url: '/useraddresses/' + formId,
                    type: 'DELETE',
                    data: {
                        "id": formId,
                        "_token": formToken,
                    },
                    success: function(res) {
                        console.log("it Works");
                        Toastify({
                            text: res.success,
                            duration: 3000,
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            },
                        }).showToast();
                        myTable.DataTable().ajax.reload();
                    }
                });
            }
        }
        var myTable = $('#displayingTable');
        var cols = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'area_id',
                name: 'area_id'
            },
            {
                data: 'customer_id',
                name: 'customer_id'
            },
            {
                data: 'street_name',
                name: 'street_name'
            },
            {
                data: 'building_number',
                name: 'building_number'
            },
            {
                data: 'floor_number',
                name: 'floor_number'
            },
            {
                data: 'flat_number',
                name: 'flat_number'
            }, {
                data: 'is_main',
                name: 'is_main'
            },
            {
                data: 'action',
                name: 'action',
            },
        ]
        let collections = {};
        $(document).ready(function() {
            //Initializing DataTables
            let collectionsTable = $("#displayingTable").dataTable({
                destroy: true,
                "data": collections,
                "columns": cols,
                processing: true,
                serverSide: true,
                "searching": false,
                ajax: {
                    url: '/useraddresses',
                    type: 'GET',
                },
            });

            //Requesting data
            $("#myBox").on('keyup', function() {
                var ser = $('#myBox').val();
                console.log("Search keyWord : " + ser);
                $.ajax({
                    method: "GET",
                    url: '/useraddresses',
                    dataType: 'json',
                    data: {
                        'searchkeyWord': ser,
                        draw: parseInt(1),
                    },
                    success: function(r) {
                        assignToEventsColumns(r);
                    },
                });
            });

            function assignToEventsColumns(data) {
                if ($.fn.DataTable.isDataTable("#displayingTable")) {
                    $('#displayingTable').DataTable().clear().destroy();
                }
                $("#displayingTable").dataTable({
                    "aaData": data.data,
                    "columns": cols,
                });
                console.log(data);
            }
        });
    </script>
    @if ($status = session('status'))
        <script>
            Toastify({
                text: '{{ $status }}',
                duration: 3000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
            }).showToast();
        </script>
    @endif
@endsection
