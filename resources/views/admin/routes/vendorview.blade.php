
@extends('admin.layouts.backend.app')

@push('style')

<style>

.vendorview-wapper .vendorview-detaisl-row {
	align-items: center;
	padding: 5px;
	margin: 0px 5px;
	border: solid 1px #e3e6ea;
}

.vendorview-wapper .vendorview-detaisl-row .vendorview-detail-lable strong {
	font-size: 14px;
	width: 100%;
	display: block;
	color: #000;
	font-weight: 600;
	padding: 10px 0px;
}

.vendorview-wapper .title,
.vendorview-wapper .ass-title {
	padding: 12px;
	font-size: 17px;
	text-transform: capitalize;
	background: #0c3e67;
	box-shadow: 0 3px 4px #eaeaea;
	width: 100%;
	color: #fff;
	border-radius: 4px;
	line-height: normal;
}

.vendorview-wapper .vendorview-detaisl-row .vendorview-detail-lable {
	position: relative;
	background: #f3f4f6;
}

.vendorview-wapper .vendorview-detaisl-row .vendorview-detail-value p {
	padding: 8px;
	font-size: 14px;
	font-weight: 500;
	color: #000;
}

.vendorview-wapper .ass-title {
	margin: 15px 0px;
}

table.associated-custom-table {
	border-color: #e3e6ea;
}

table.associated-custom-table thead {
	background: #e7e7e7;
}

table.associated-custom-table tr th {
	color: #000;
	font-size: 13px;
	font-weight: 700;
}


table.associated-custom-table tbody tr:last-child {
	border: none;
}

table.associated-custom-table tbody tr td {
	padding: 12px;
	color: #565656;
	font-size: 13px;
	border: solid 1px #e3e6ea;
}

.vendorview-wapper .vendorview-detaisl-row img {
	padding: 10px;
	display: block;
	width: 100%;
	max-width: 90px;
	max-height: 90px;
	object-fit: cover;
	object-position: center;
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
                        <h5 class="m-b-10">Vendors</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.routes.index') }}">Vendor</a></li>
                        <li class="breadcrumb-item">View</li>
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
                            
                            <!-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Customer</span>
                            </a> -->
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
                <div class="col-xxl-12 ">
                    <div class=" vendorview-wapper card border-top-0 p-4">
                        <h6 class="mb-4 title">Vendor Details</h6>
                        <div class="row mb-3 vendorview-detaisl-row">
                            <div class="col-md-4 vendorview-detail-lable"><strong>Vendor Name:</strong></div>
                            <div class="col-md-8 vendorview-detail-value"><p class="text-muted mb-0">{{ $vendor->first_name }} {{ $vendor->last_name }}</p></div>
                        </div>
                       
                       
                        <div class="row mb-3 vendorview-detaisl-row">
                            <div class="col-md-4 vendorview-detail-lable"><strong>Mobile:</strong></div>
                            <div class="col-md-8 vendorview-detail-value"><p class="text-muted mb-0">{{ $vendor->phone_number }}</p></div>
                        </div>
        
                        <div class="row mb-3 vendorview-detaisl-row">
                            <div class="col-md-4 vendorview-detail-lable"><strong>Logo:</strong></div>
                            @if(isset($vendor) && $vendor->avatar != null)
                                <img src="{{ asset($vendor->avatar) }}" alt="User Avatar" style="width:100px; height:100px;">
                            @else
                                <p class="text-muted mb-0">No image available</p>
                            @endif 
                        </div>
                        <div class="row mb-3 vendorview-detaisl-row">
                            <div class="col-md-4 vendorview-detail-lable"><strong>Type:</strong></div>
                            <div class="col-md-8 vendorview-detail-value"><p class="text-muted mb-0">{{ $vendor->role == 2 ? 'Customer' : ($vendor->role == 3 ? 'Vendor' : 'Unknown') }}</p></div>
                        </div>
                        <div class="row mb-3 vendorview-detaisl-row">
                            <div class="col-md-4 vendorview-detail-lable"><strong>Created On:</strong></div>
                            <div class="col-md-8 vendorview-detail-value"><p class="text-muted mb-0">{{ date('Y, M d', strtotime($vendor->created_at)) }}</p></div>
                        </div>
                        <div class="row mb-3 vendorview-detaisl-row">
                            <div class="col-md-4 vendorview-detail-lable"><strong> Status:</strong></div>
                            <div class="col-md-8 vendorview-detail-value"><p class="text-muted mb-0">{{ $vendor->status == 1 ? 'Active' : 'Inactive' }}</p></div>
                        </div>
                        <!-- Tasks Display -->
                        <!-- <h6 class="mb-4">Tasks</h6> -->
                        <h3 class=" ass-title">Associated Customers</h3>
                        <table border="1" cellpadding="10" cellspacing="0" width="100%" class="associated-custom-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Destination</th>
                                    <th>Credit Limit</th>
                                    <th>Billing Cycle</th>
                                    <th>Agreement Review</th>
                                    <th>Agreement Sign</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    @if($customer->tasks->isNotEmpty())
                                        @foreach($customer->tasks as $task)
                                            <tr>
                                                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                                <td>{{ $task->destination }}</td>
                                                <td>{{ $task->credit_limit }}</td>
                                                <td>{{ $task->billing_cycle }}</td>
                                                <td>{!! Str::limit($task->agreement_review, 20) !!}</td>
                                                <td>{{ $task->agreement_sign }}</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                            <td colspan="2">No tasks available</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                       
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