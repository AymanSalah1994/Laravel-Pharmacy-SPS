@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('pharmacies.create')}}" class="btn btn-primary fw-bold fs-4 d-flex justify-content-center">Create New Pharmacy</a>
    <br>
    <a href="{{ route('pharmacies.restore.all')}}" class="btn btn-secondary  fw-bold mb-3">Restore ALL Pharmacies</a>
    <form action="" method="" class="mb-3">
        <input type="text" name="searchkeyword" id="myBox">
    </form>
    <table class="table table-bordered yajra-datatable text-center shadow my-3" id="displayingTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>National Id</th>
                <th>Avatar Image</th>
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
            let result = confirm("Are you Sure you Want to Delete ? ");
            console.log(result);
            if (result) {
                let form = document.getElementById(formId);
                // form.submit();
                $.ajax({
                    url: '/pharmacies/' + formId,
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'national_id',
                name: 'national_id'
            }, {
                data: 'avatar_image',
                name: 'avatar_image'
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
                    url: '/pharmacies',
                    type: 'GET',
                },
            });

            //Requesting data
            $("#myBox").on('keyup', function() {
                var ser = $('#myBox').val();
                console.log("Search keyWord : " + ser);
                $.ajax({
                    method: "GET",
                    url: '/pharmacies',
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
