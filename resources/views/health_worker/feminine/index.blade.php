@extends('layouts.app')
@section('page-title', 'Assigned Feminine List')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/feminine_list.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/blood.jpg') }}">
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
                <div class="d-flex align-items-baseline flex-wrap mb-md-3" style="margin-bottom: 0 !important;">
                    <h6 class="card-title flex-grow-1 mb-2 mb-md-0">Assigned Female Residence List</h6>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Actions" style="flex-wrap: wrap;">
                        <button type="button" class="btn btn-outline-primary mr-2 mb-2" data-toggle="modal" data-target="#assignFeminineModal">
                        <i class="fa-solid fa-user-tag"></i> Assign Feminine
                        </button>
                        <button type="button" class="btn btn-primary mr-2 mb-2" data-toggle="modal" data-target="#newFeminineModal">
                        <i class="fa-solid fa-plus"></i> Add New Feminine
                        </button>
                        <button type="button" class="btn btn-danger pdf-button mb-2" onclick="printFeminineList()">
                        <i class="fa-solid fa-print"></i> Print
                        </button>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

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
            drawCallback: function (settings) {
                updateTotals(settings.json.data);
            }
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
    
    // Clone the table and remove the unwanted columns (Account Status and Action)
    var clonedTable = table.cloneNode(true);
    var rows = clonedTable.rows;

    for (var i = 0; i < rows.length; i++) {
        // Remove 'Account Status' and 'Action' columns
        if (rows[i].cells.length >= 6) {
            rows[i].deleteCell(5); // Action column
            rows[i].deleteCell(3); // Account Status column
        }
    }

    // Mobile PDF generation logic
    if (/Mobi|Android/i.test(navigator.userAgent)) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Adding title to PDF
        doc.setFontSize(18);
        doc.text('Female Residents List', 10, 10);

        // Use jsPDF's autoTable to convert the HTML table to PDF
        doc.autoTable({
            html: clonedTable, // Pass the cloned table for autoTable
            startY: 20,
            theme: 'striped', // Optional theme for styling
            styles: {
                fontSize: 10, // Make text smaller for mobile view
                cellPadding: 2
            },
            headStyles: {
                fillColor: [255, 0, 0] // Optional: Add a custom color for header
            }
        });

        // Save the generated PDF on mobile
        doc.save('Feminine_List.pdf');
    } else {
        // Desktop print view (Open a new window and print)
        var newWindow = window.open('', '', 'height=500, width=800');
        newWindow.document.write('<html><head><title>Assigned Feminine List</title>');
        newWindow.document.write('<link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">');
        newWindow.document.write('<style>');
        newWindow.document.write('th.sorting::after, th.sorting_asc::after, th.sorting_desc::after { display: none !important; }');
        newWindow.document.write('h2 { text-align: center; }');
        newWindow.document.write('table { margin: 0 auto; }');
        newWindow.document.write('body { position: relative; padding: 0 20px; }');
        newWindow.document.write('.logo { position: absolute; top: 0px; }');
        newWindow.document.write('.logo.left { left: 100px; width: 90px; }');
        newWindow.document.write('.logo.right { right: 100px; width: 90px; }');
        newWindow.document.write('</style>');
        newWindow.document.write('</head><body>');
        newWindow.document.write('<h2>Female Residents List</h2>');
        newWindow.document.write(clonedTable.outerHTML); // Output cloned table HTML
        newWindow.document.write('</body></html>');
        newWindow.document.close();
        newWindow.print();
    }
}
</script>
