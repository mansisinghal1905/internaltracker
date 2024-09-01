
@extends('admin.layouts.backend.app')

@section('content')

<main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Customers</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.routes.index') }}">Customer</a></li>
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
                    <div class="card border-top-0 p-4">
                        <h6 class="mb-4">Customer Details</h6>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Customer Name:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $customer->first_name }} {{ $customer->last_name }}</p></div>
                        </div>
                       
                       
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Mobile:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $customer->phone_number }}</p></div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Logo:</strong></div>
                            @if(isset($customer) && $customer->avatar != null)
                                <img src="{{ asset($customer->avatar) }}" alt="User Avatar" style="width:100px; height:100px;">
                            @else
                                <p class="text-muted mb-0">No image available</p>
                            @endif 
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Type:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $customer->role == 2 ? 'Customer' : ($customer->role == 3 ? 'Vendor' : 'Unknown') }}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Created On:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ date('Y, M d', strtotime($customer->created_at)) }}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong> Status:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $customer->status == 1 ? 'Active' : 'Inactive' }}</p></div>
                        </div>
                        <!-- Tasks Display -->
                        <!-- <h6 class="mb-4">Tasks</h6> -->
                        @if($usercustomer->tasks->isNotEmpty())
                            
                                @foreach($usercustomer->tasks as $task)
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong> Vendor:</strong></div>
                                    <div class="col-md-8"><p class="text-muted mb-0">{{ $task->getVendor->first_name}} {{ $task->getVendor->last_name}}</p></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong> Destination:</strong></div>
                                    <div class="col-md-8"><p class="text-muted mb-0">{{ $task->destination }}</p></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Credit Limit:</strong></div>
                                    <div class="col-md-8"><p class="text-muted mb-0">{{ $task->credit_limit }}</p></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Billing Cycle:</strong></div>
                                    <div class="col-md-8"><p class="text-muted mb-0">{{ $task->billing_cycle }}</p></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Agreement Review:</strong></div>
                                    <div class="col-md-8"><p class="text-muted mb-0">{!! Str::limit($task->agreement_review, 50) !!}</p></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Agreement Sign:</strong></div>
                                    <div class="col-md-8"><p class="text-muted mb-0">{{ $task->agreement_sign }}</p></div>
                                </div>
                                @endforeach
                            
                        @else
                            <p class="text-muted mb-0">No tasks available</p>
                        @endif
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