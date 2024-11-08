@extends('admin.layouts.backend.app')

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
                    <li class="breadcrumb-item">View</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-primary d-flex align-items-center">
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
                <div class="col-xxl-12">
               
                    <div class="card border-top-0 p-4">
                        <h6 class="mb-4">Task Details</h6>
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0 me-4">
                                <span class="d-block mb-2">New Interconnection:</span>
                            </h5>
                        </div>
                      

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Company Name:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $task->company_name ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Country:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $task->getCountry->name ?? 'N/A' }}</p></div>
                        </div> 
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>AM Name:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $task->am_name ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>AM Email:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $task->am_email ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Whatsapp No.:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $task->whatsapp_no ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Task Status:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ ucfirst($task->task_status ?? 'N/A') }}</p></div>
                        </div>
                       
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Created On:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ date('Y, M d', strtotime($task->created_at)) }}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Status:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $task->status == 1 ? 'Active' : 'Inactive' }}</p></div>
                        </div>

                        {{-- Display multiple descriptions --}}
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Descriptions:</strong></div>
                            <div class="col-md-8">
                                @if($taskDescriptions->isNotEmpty())
                                    <ul class="list-unstyled text-muted mb-0">
                                        @foreach($taskDescriptions as $description)
                                            <li>{{ $description->description ?? 'N/A' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">N/A</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0 me-4">
                                <span class="d-block mb-2">Trade Verifications:</span>
                            </h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Response Of Tr:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $tradeverification->response_of_tr ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Propose Credit Limit($):</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $tradeverification->propose_credit_limit ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Billing Cycle:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $tradeverification->billing_cycle ?? 'N/A'}}</p></div>
                        </div>
                        
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0 me-4">
                                <span class="d-block mb-2">Agreement Review:</span>
                            </h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Review Description:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $agreementreview->review_description ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Financial Statement:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $agreementreview->financial_statement ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Billing Cycle:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $agreementreview->billing_cycle_review ?? 'N/A'}}</p></div>
                        </div>

                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0 me-4">
                                <span class="d-block mb-2">Agreement Sign:</span>
                            </h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Agreement:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $agreementsign->agreement ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Unilateral:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $agreementsign->unilateral ?? 'N/A'}}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Sign Description:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $agreementsign->sign_description ?? 'N/A'}}</p></div>
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
