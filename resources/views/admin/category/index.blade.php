
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
                        <h5 class="m-b-10">Designation</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Designation</li>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-light-brand" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="feather-bar-chart"></i>
                            </a>
                            <div class="dropdown">
                                <a class="btn btn-icon btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10" data-bs-auto-close="outside">
                                    <i class="feather-filter"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-eye me-3"></i>
                                        <span>All</span>
                                    </a>
                                    <!-- <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-users me-3"></i>
                                        <span>Group</span>
                                    </a> -->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-flag me-3"></i>
                                        <span>Country</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-dollar-sign me-3"></i>
                                        <span>Invoice</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-briefcase me-3"></i>
                                        <span>Project</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-user-check me-3"></i>
                                        <span>Active</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-user-minus me-3"></i>
                                        <span>Inactive</span>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-icon btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10" data-bs-auto-close="outside">
                                    <i class="feather-paperclip"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-pdf me-3"></i>
                                        <span>PDF</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-csv me-3"></i>
                                        <span>CSV</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-xml me-3"></i>
                                        <span>XML</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-txt me-3"></i>
                                        <span>Text</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-exe me-3"></i>
                                        <span>Excel</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-printer me-3"></i>
                                        <span>Print</span>
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Designation</span>
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
            <div id="collapseOne" class="accordion-collapse collapse page-header-collapse">
                <div class="accordion-body pb-2">
                    <div class="row">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-users"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="text-truncate-1-line">Total Customers</span>
                                                <span class="fs-24 fw-bolder d-block">26,595</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-success text-success">
                                            <i class="feather-arrow-up fs-10 me-1"></i>
                                            <span>36.85%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-user-check"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="text-truncate-1-line">Active Customers</span>
                                                <span class="fs-24 fw-bolder d-block">2,245</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-danger text-danger">
                                            <i class="feather-arrow-down fs-10 me-1"></i>
                                            <span>24.56%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-user-plus"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="text-truncate-1-line">New Customers</span>
                                                <span class="fs-24 fw-bolder d-block">1,254</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-success text-success">
                                            <i class="feather-arrow-up fs-10 me-1"></i>
                                            <span>33.29%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-user-minus"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="text-truncate-1-line">Inactive Customers</span>
                                                <span class="fs-24 fw-bolder d-block">4,586</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-danger text-danger">
                                            <i class="feather-arrow-down fs-10 me-1"></i>
                                            <span>42.47%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <table class="table table-hover data-table1 table stripe hover nowrap" id="categoryList">
                                        <thead>
                                            <tr>
                                                <th class="wd-30">
                                                    <div class="btn-group mb-1">
                                                        <div class="custom-control custom-checkbox ms-1">
                                                            <input type="checkbox" class="custom-control-input" id="checkAllCustomer">
                                                            <label class="custom-control-label" for="checkAllCustomer"></label>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th class="">Actions</th>
                                            </tr>
                                        </thead>
                                        <!-- <tbody>
                                            <tr class="single-item">
                                                <td>
                                                    <div class="item-checkbox ms-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input checkbox" id="checkBox_1">
                                                            <label class="custom-control-label" for="checkBox_1"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="customers-view.html" class="hstack gap-3">
                                                        <div class="avatar-image avatar-md">
                                                            <img src="{{ asset('public/assets/images/avatar/1.png')}}" alt="" class="img-fluid">
                                                        </div>
                                                        <div>
                                                            <span class="text-truncate-1-line">Alexandra Della</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td><a href="apps-email.html">alex.della@outlook.com</a></td>
                                                
                                                <td><a href="tel:">+1 (375) 9632 548</a></td>
                                                <td>2023-04-05, 00:05PM</td>
                                                <td>
                                                    <select class="form-control" data-select2-selector="status">
                                                        <option value="success" data-bg="bg-success" selected>Active</option>
                                                        <option value="warning" data-bg="bg-warning">Inactive</option>
                                                        <option value="danger" data-bg="bg-danger">Declined</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="customers-view.html" class="avatar-text avatar-md">
                                                            <i class="feather feather-eye"></i>
                                                        </a>
                                                        <a href="" class="avatar-text avatar-md edit-action">
                                                            <i class="feather feather-edit"></i>
                                                        </a>
                                                        <a href="customers-delete.html" class="avatar-text avatar-md delete-action">
                                                            <i class="feather feather-trash-2"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                          
                                        </tbody> -->
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

			// $(".selectstatus").on("click", function () {
			// 	id = $(this).data("id");
			// 	alert(id);
			// });
			var table = $('#categoryList').DataTable({
				processing: true,
				serverSide: true,
				"scrollY": "400px", // Set the height for the container
				"scrollCollapse": true, // Allow the container to collapse when the content is smaller
				"scrollX": false,
				pagingType: "simple_numbers", // Use simple pagination (Previous/Next)

				ajax: {
					url: "{{ route('admin.categoryAjax') }}",
					type: "POST",
					data: {
                        status: $('input[name=status]').val(),
						search: $('input[name=name]').val(),
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
				{ "data": "name" },
                { "data": "status" },
				{ "data": "view" },

				],
                columnDefs: [
                    { "targets": [2,3], "orderable": false }, // Disable sorting on the "job_id" column
                    { "targets": [], "orderable": false } // Disable sorting on the "job_id" column
                ]
			});

			// for chnage status
            $(document).on('change', '.categoryStatusToggle', function () {
                var id = $(this).attr("data-id");
                var status = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    type: "POST",
                    url: @json(route('admin.changeCategoryStatus')),
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
		});

        function deleteCategory(element) {
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
                                'The Designation has been deleted.',
                                'success'
                            );
                            
                            setTimeout(function() {
                            location.reload();
                        }, 2000);
                        },
                        error: function(response) {
                            Swal.fire(
                                'Failed!',
                                'There was an error deleting the Designation.',
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