@extends('layouts.app')
@section('page-title', 'Assigned Feminine List')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/feminine_list.css') }}">
@endsection
<style>
    .pdf-button:hover {
    background-color: #ff4d4d; /* Change to a lighter shade of red or any color you prefer */
    border-color: #ff4dec; /* Change to match the background color */
    color: white; /* Change text color if needed */
}
</style>
@section('contents')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex align-items-baseline mb-md-3" style="margin-bottom: 0 !important;">
                  <h6 class="card-title flex-grow-1 mb-0">Assigned Feminine List</h6>
                   <button type="button" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#assignFeminineModal">
                     <i class="fa-solid fa-user-tag"></i> Assign Feminine
                   </button>
                   <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#newFeminineModal">
                     <i class="fa-solid fa-plus"></i> Add New Feminine
                   </button>
                   <button type="button" class="btn btn-sm btn-danger pdf-button" onclick="printFeminineList()">
                     <i class="fa-solid fa-print"></i> Print
                   </button>
                </div>


                  <p class="card-description mb-4 mt-2">This is your assigned feminine list, other feminine that are not under your care or assigned to you will not be displayed here.</p>
                    <div class="table-responsive">
                        <table id="feminine_table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Menstruation Status</th>
                                    <th>Account Status</th>
                                    <th>Estimated Menstrual Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('health_worker.feminine.modal')

@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/select2/select2.min.js') }}"></script>
    
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/health_worker/new_feminine.js') }}"></script>
    <script src="{{ asset('assets/js/health_worker/edit_feminine.js') }}"></script>

    <script src="{{ asset('assets/js/health_worker/feminine_dt.js') }}"></script>
@endsection
<script>
    $(function () {
        if (!$.fn.DataTable.isDataTable('#feminine_table')) {
            $("#feminine_table").DataTable({
                aLengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                iDisplayLength: 10,
                sAjaxSource: "../health-worker/feminine-data",
                columns: [
                    { data: "row_count" },
                    { data: "full_name" },
                    { data: "menstruation_status" },
                    { data: "is_active" },
                    { data: "estimated_menstrual_status" },
                    { data: "action" }
                ],
                drawCallback: function(settings) {
                    updateTotals(settings.json.data);
                }
            });
            $("#feminine_table").each(function () {
                var datatable = $(this);
                var search_input = datatable
                    .closest(".dataTables_wrapper")
                    .find("div[id$=_filter] input");
                search_input.attr("placeholder", "Search");
                search_input.removeClass("form-control-sm");

                var length_sel = datatable
                    .closest(".dataTables_wrapper")
                    .find("div[id$=_length] select");
                length_sel.removeClass("form-control-sm");
            });
        }
    });

    function updateTotals(data) {
        var totalActive = 0;
        var totalInactive = 0;
        data.forEach(item => {
            if (item.is_active === 'Active') {
                totalActive++;
            } else {
                totalInactive++;
            }
        });
        document.getElementById('total_active').innerText = totalActive;
        document.getElementById('total_inactive').innerText = totalInactive;
    }

    function printFeminineList() {
        var table = document.getElementById('feminine_table');
        var clonedTable = table.cloneNode(true);
        var rows = clonedTable.rows;

        // Hide the "Account Status" and "Action" columns
        for (var i = 0; i < rows.length; i++) {
            rows[i].deleteCell(5);
            rows[i].deleteCell(3);
        }

        // Create separate tables for the required columns
        var headerTable = '<table border="1" style="width:100%; border-collapse: collapse; margin-bottom: 20px;"><thead><tr>';
        headerTable += '<th>Name</th>';
        headerTable += '<th>Menstruation Status</th>';
        headerTable += '<th>Estimated Menstrual Status</th>';
        headerTable += '</tr></thead><tbody>';

        var nameTable = '';
        for (var i = 1; i < rows.length; i++) {  // Start from 1 to skip the header row
            nameTable += '<tr>';
            nameTable += '<td>' + rows[i].cells[1].innerText + '</td>';
            nameTable += '<td>' + rows[i].cells[2].innerText + '</td>';
            nameTable += '<td>' + rows[i].cells[3].innerText + '</td>';
            nameTable += '</tr>';
        }

        headerTable += nameTable + '</tbody></table>';

        // Assuming you have variables for user information from the database
        var newWindow = window.open('', '', 'height=500, width=800');
        newWindow.document.write('<html><head><title>Assigned Feminine List</title>');
        newWindow.document.write('<link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">');
        newWindow.document.write('<style>');
        newWindow.document.write('th.sorting::after, th.sorting_asc::after, th.sorting_desc::after { display: none !important; }');
        newWindow.document.write('h2 { text-align: center; }');
        newWindow.document.write('p { text-align: center; }');
        newWindow.document.write('table { margin: 0 auto; }');
        newWindow.document.write('</style>');
        newWindow.document.write('</head><body>');
        newWindow.document.write('<h2>Assigned Feminine List</h2>');
        newWindow.document.write(headerTable);
        newWindow.document.write('</body></html>');
        newWindow.document.close();
        newWindow.print();
    }
</script>

