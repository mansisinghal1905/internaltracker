
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
                        <h5 class="m-b-10">Vendor Payment</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.vendor-payments.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Vendor Payment</li>
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
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            
                            <a href="{{ route('admin.vendor-payments.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Vendor Payment</span>
                            </a>
                        </div>
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
                                    <table class="table table-hover data-table1 table stripe hover nowrap" id="paymentList">
                                        <thead>
                                            <tr>
                                                <th class="wd-30">
                                                    S.No.
                                                </th>
                                                <th>Vendors</th>
                                                <th>Amount($)</th>
                                                <th>Date</th>
                                                <th class="">Actions</th>
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
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			
			var table = $('#paymentList').DataTable({
				processing: true,
				serverSide: true,
				"scrollY": "400px", // Set the height for the container
				"scrollCollapse": true, // Allow the container to collapse when the content is smaller
				"scrollX": false,
				pagingType: "simple_numbers", // Use simple pagination (Previous/Next)

				ajax: {
					url: "{{ route('admin.vendorpaymentAjax') }}",
					type: "POST",
					data: {
                    
						search: $('input[name=total_amount]').val(),
						search: $('input[name=created_at]').val(),
					},
					dataSrc: "data"
				},
				paging: true,
				pageLength: 10,
				"bServerSide": true,
				"bLengthChange": false,
				'searching': true,
				"aoColumns": [{
					"data": "id"
				},
				{ "data": "vendor_id" },
                { "data": "total_amount" },
                { "data": "created_at" },
				{ "data": "view" },

				],
                columnDefs: [
                    { "targets": [1,2,3], "orderable": false }, // Disable sorting on the "job_id" column
                    { "targets": [], "orderable": false } // Disable sorting on the "job_id" column
                ]
			});

			
		});

        function deletePayments(element) {
            var url = element.getAttribute('data-url');
            var id = element.getAttribute('data-id');
            
            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'post',
                    
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The Payment has been deleted.',
                                'success'
                            );
                            
                            setTimeout(function() {
                            location.reload();
                        }, 2000);
                        },
                        error: function(response) {
                            Swal.fire(
                                'Failed!',
                                'There was an error deleting the Payment.',
                                'error'
                            );
                        }
                    });
                }
            });
        }




	</script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endpush