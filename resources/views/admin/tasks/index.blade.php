
@extends('admin.layouts.backend.app')
@push('style')
<style>
#toast-container .toast-success {
    background-color: #28a745; /* Green color */
    color: #fff;
}
</style>
@endpush
@section('content')
<main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Task</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Task</li>
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
                           
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Task</span>
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
                                    <table class="table table-hover data-table1 table stripe hover nowrap" id="taskList">
                                        <thead>
                                            <tr>
                                                <th class="wd-30">
                                                   S.No.
                                                </th>
                                                <th>Company</th>
                                                <th>AM Name</th>
                                                <th>Task Status</th>
                                                <th>Status</th>
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
<!-- 
<script src="{{ asset('public/assets/src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{ asset('public/assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{ asset('public/assets/src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{ asset('public/assets/src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{ asset('public/assets/vendors/scripts/datatable-setting.js')}}"></script> -->


<script type="text/javascript">
		$(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// $(".selectstatus").on("click", function () {
			// 	id = $(this).data("id");
			// 	alert(id);
			// });
			var table = $('#taskList').DataTable({
				processing: true,
				serverSide: true,
				"scrollY": "400px", // Set the height for the container
				"scrollCollapse": true, // Allow the container to collapse when the content is smaller
				"scrollX": false,
				pagingType: "simple_numbers", // Use simple pagination (Previous/Next)

				ajax: {
					url: "{{ route('admin.taskAjax') }}",
					type: "POST",
					data: {
                        status: $('input[name=status]').val(),
						search: $('input[name=company_name]').val(),
                        search: $('input[name=am_name]').val(),
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
                { "data": "company_name" },
                { "data": "am_name" },
				{ "data": "task_status" },
                { "data": "status" },
				{ "data": "view" },

				],
                columnDefs: [
                    { "targets": [1,2,3,4], "orderable": false }, // Disable sorting on the "job_id" column
                    { "targets": [], "orderable": false } // Disable sorting on the "job_id" column
                ]
			});

            // for chnage status
            $(document).on('change', '.taskStatusToggle', function () {
                var id = $(this).attr("data-id");
                var status = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    type: "POST",
                    url: @json(route('admin.ChangeTaskStatus')),
                    data: { id: id, status: status },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success(response.message); // Show success toast
                            table.ajax.reload(); // Reload the table to reflect the changes
                        } else {
                            toastr.error(response.message); // Show error toast
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error("An error occurred while changing the status."); // Show generic error toast
                        console.error(error);
                    }
                });
            });

            $(document).on('change', '.status-select', function() {
            var status = $(this).val();
            var recordId = $(this).data('id');

            $.ajax({
                url: @json(route('admin.update.status')),
                method: 'POST',
                data: {
                    id: recordId,
                    task_status: status
                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {
                    if (response.status==true) {
                        toastr.success(response.message); // Show success toast with green background
                        table.ajax.reload(); // Reload the table to reflect the changes
                    } else {
                        toastr.error(response.message); // Show error toast with red background
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("An error occurred while changing the status."); // Show generic error toast with red background
                    console.error(error);
                }
            });
        });

		});


        function deleteTasks(element) {
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
                                'The Task has been deleted.',
                                'success'
                            );
                            
                            setTimeout(function() {
                            location.reload();
                        }, 2000);
                        },
                        error: function(response) {
                            Swal.fire(
                                'Failed!',
                                'There was an error deleting the Task.',
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