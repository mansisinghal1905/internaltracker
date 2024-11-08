@extends('admin.layouts.backend.app')

@section('content')

<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Ticket System</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.ticket-system.index') }}">Home</a></li>
                    <li class="breadcrumb-item">View</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.ticket-system.index') }}" class="btn btn-outline-primary d-flex align-items-center">
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
                        <h6 class="mb-4">Ticket Details</h6>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Ticket Code:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $ticket->ticket_code }}</p></div>
                        </div>
                        @if(Auth::user()->role == 1)
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>User:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $ticket->getAllUser->first_name}} {{ $ticket->getAllUser->last_name}}</p></div>
                        </div>
                        @endif
                        <!-- <div class="row mb-3">
                            <div class="col-md-4"><strong>Email:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $ticket->customer_email}} </p></div>
                        </div> -->
                        
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Subject:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{!! Str::limit($ticket->subject, 50) !!}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Department:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{!!$ticket->department == 2 ? 'Account' : ($ticket->department == 3 ? 'Billing' : ($ticket->department == 4 ? 'Technical' : 'Unknown')) !!}</p></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Priority:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ ucfirst($ticket->priority) }}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Message:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{!! Str::limit($ticket->message, 100) !!}</p></div>
                        </div>
                       
                       
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Created On:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ date('Y, M d', strtotime($ticket->created_at)) }}</p></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Status:</strong></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $ticket->status == 1 ? 'Active' : 'Inactive' }}</p></div>
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
