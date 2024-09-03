
@extends('admin.layouts.backend.app')

@push('style')

@Endpush
@section('content')
<main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vendor</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.technical-customers.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Vendor</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                       
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
         
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover data-table1 table stripe hover nowrap" id="technicalvendorList">
                                        <thead>
                                            <tr>
                                                <th class="wd-30">
                                                    S.No.
                                                </th>
                                                <th>Vendor</th>
                                                <th>Date</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
        <!-- [ Footer ] start -->
        <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
            </div>
        </footer>
        <!-- [ Footer ] end -->
    </main>
@endsection

@push('script')

<script type="text/javascript">
		$(function () {
    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize DataTable
    var table = $('#technicalvendorList').DataTable({
        processing: true,          // Enable processing display
        serverSide: true,          // Enable server-side processing
        scrollY: "400px",          // Set height for the container
        scrollCollapse: true,      // Allow container to collapse when content is smaller
        scrollX: false,            // Disable horizontal scrolling
        pagingType: "simple_numbers", // Use simple pagination (Previous/Next)
        paging: true,              // Enable pagination
        pageLength: 10,            // Set the number of records per page
        lengthChange: false,       // Disable ability to change page length
        searching: true,           // Enable the search functionality

        // Define AJAX call
        ajax: {
            url: "{{ route('admin.technicalvendorAjax') }}", // Your server-side route
            type: "POST",            // Use POST method for AJAX request
            data: function (d) {
                d.first_name = $('input[name=first_name]').val();
                d.last_name = $('input[name=last_name]').val();
                d.created_at = $('input[name=created_at]').val();
            },
            dataSrc: "data"     
        },

        // Define the columns
        columns: [
            { data: "id" },
            { data: "fullname" },
            { data: "created_at" },
            { data: "view" }

        ],

        // Column definitions
        columnDefs: [
            { targets: [2], orderable: false } // Disable sorting on the "created_at" column
        ]
    });
});


       



	</script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->


@endpush