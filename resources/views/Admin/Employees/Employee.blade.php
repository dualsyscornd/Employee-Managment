@extends('Layout')
@section('title','Empolyee Management || Employees')
@section('content')

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="mt-1">Employee Managment</h4>
            <button class="btn btn-primary m-0" data-bs-toggle="modal" data-bs-target="#EmployeeStoreModal"> Add
                Employee</button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Employee List <i class="link-icon data-feather="mail"></i></h5>
    </div>
    <div class="card-body">
        <table id="tables" class="table dataTable no-footer">
            <thead>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Employee Position</th>
                <th>Employee Profile</th>
                <th>Action</th>
            </thead>
        </table>
    </div>
</div>

<!-- Employee Store Modal  -->
<div class="modal fade" id="EmployeeStoreModal" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingModalLabel">Employee Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="EmployeeStoreForm">
                    @csrf
                    <div class="mb-3">
                        <label for="recipient-name" class="form-label">Employee Name</label>
                        <input type="text" class="form-control required" id="employee_name" name="employee_name"
                            placeholder="Enter Employee Name">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="form-label">Employee Email</label>
                        <input type="email" class="form-control required" id="employee_email" name="employee_email"
                            placeholder="Enter Employee Email">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="form-label">Employee Position</label>
                        <input type="text" class="form-control required" id="employee_position" name="employee_position"
                            placeholder="Enter Employee Position">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="form-label">Employee Password</label>
                        <input type="password" class="form-control required" id="employee_password"
                            name="employee_password" placeholder="Enter Employee Password">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="form-label">Employee Profile</label>
                        <input type="file" class="form-control required" id="employee_profile" name="employee_profile"
                            placeholder="Enter Employee Profile">
                    </div>
                </form>
                <div class="error text-center">
                    <div id="error"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary login-btn" onclick="EmployeeStore()">
                    <span class="spinner-border d-none  spinner-border-sm" role="status" aria-hidden="true"></span>Store
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Employee Store Modal  -->


<!-- Ajax Script -->
<script>
$(document).ready(function() {
    var dataTables = $('#tables').DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('EmployeeList') }}",
        },
        columns: [{
                data: 'employee_name',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'employee_email',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'employee_position',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'employee_profile',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'action',
                "searchable": false,
                "orderable": false,
            },
        ],
        "initComplete":function( settings, json){
            feather.replace()
        }
    });
})

// --- === Employee Store Fucntion === --- \\
function EmployeeStore() {
    // --- Frontend Validation --- \\
    var fields = $("input[class*='required']");
    for (let i = 0; i <= fields.length; i++) {
        if ($(fields[i]).val() === '') {
            var currentElement = $(fields[i]).attr('id');
            var value = currentElement.replaceAll('_', ' ');
            $("#error").removeClass().html('');
            $("#error").show().addClass('alert alert-danger').html('The ' + value + ' field is required.');
            return false;
        } else {
            $("#error").hide().removeClass().html('');
        }
    }
    // --- Frontend Validation --- \\

    // --- FormData --- \\
    var form = document.getElementById('EmployeeStoreForm');
    var DataForm = new FormData(form)
    // --- FormData --- \\

    // --- Ajax request --- \\
    $.ajax({
        type: "POST",
        url: "{{route('EmployeeStore')}}",
        data: DataForm,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(".login-btn").prop('disabled', true);
            $(".spinner-border").removeClass('d-none')
        },
        success: function(data) {
            $(".login-btn").prop('disabled', false);
            $(".spinner-border").addClass('d-none')
            $("#EmployeeStoreModal").modal('hide');
        }
    })
    // --- Ajax request --- \\
}
// --- === Employee Store Fucntion === --- \\


// --- === Employee Edit Fucntion === --- \\
function EmployeeEdit (employee_id){
}
// --- === Employee Edit Fucntion === --- \\
</script>
<!-- Ajax Script -->
@endsection
