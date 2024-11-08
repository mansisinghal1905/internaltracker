
@extends('admin.layouts.backend.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/addon.css')}}" />
@endpush
@section('content')
<main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Trade Verification</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Create</li>
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
                    <div class="col-lg-12">
                        <div class="card border-top-0">
                           
                            <div class="tab-content">
                                
                                <div class="tab-pane fade show active" id="profileTab" role="tabpanel">
                                    <div class="card-body personal-info">

                                    <form action="{{ $task ? route('admin.tasks.update', $task->id) : route('admin.tradeverifications.store') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        @if($task)
                                            @method('PUT')
                                        @endif
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @elseif (session('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="mb-4 d-flex align-items-center justify-content-between">
                                            <h5 class="fw-bold mb-0 me-4">
                                                <span class="d-block mb-2">Trade Verification:</span>
                                            </h5>
                                        </div>

                                        <div class="tab-pane fade show active" id="profileTab" role="tabpanel">
                                            <div class="card-body personal-info">
                                                <!-- <div class="mb-4 d-flex align-items-center justify-content-between">
                                                    <h5 class="fw-bold mb-0 me-4">
                                                        <span class="d-block mb-2">New Interconnection:</span>
                                                    </h5>
                                                </div> -->

                                                <div class="row mb-4 align-items-center">
                                                                    <div class="col-lg-4">
                                                                        <label for="fullnameInput" class="fw-semibold">Response of TR: </label>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="input-group">
                                                                            <textarea class="form-control"
                                                                                id="" name="response_of_tr"  id="addressInput_2"  placeholder="Response of TR..">{{ isset($tradeverification->response_of_tr) && !empty($tradeverification->response_of_tr) ? $tradeverification->response_of_tr : ''}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4 align-items-center">
                                                                <div class="col-lg-4">
                                                                    <label for="fullnameInput" class="fw-semibold">propose Credit Limit($):</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="input-group">
                                                                        <input type="number" name="propose_credit_limit" class="form-control" 
                                                                            value="{{ isset($tradeverification->propose_credit_limit) && !empty($tradeverification->propose_credit_limit) ? '' . $tradeverification->propose_credit_limit : ''}}" 
                                                                            id="creditLimitInput" placeholder="propose Credit Limit">
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                <div class="row mb-4 align-items-center">
                                                                <div class="col-lg-4">
                                                                    <label for="fullnameInput" class="fw-semibold"> Billing Cycle: </label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="input-group">
                                                                        <input type="text" name="billing_cycle" class="form-control" value="{{ isset($tradeverification->billing_cycle) && !empty($tradeverification->billing_cycle) ? $tradeverification->billing_cycle : ''}}" id="fullnameInput" placeholder="Billing Cycle">
                                                                    </div>
                                                                </div>
                                                                </div>
                                            </div>
                                           


                                                    <!--accordion sec End -->

                                        </div>
             
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>

                                        
                                        <!-- End section -->
                                    </form>
                                    </div>
                                </div>

                                <!-- Bank Detail -->
                                
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
<script src="{{ asset('public/assets/js/custom.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create( document.querySelector( '#editor1' ) )
        .catch( error => {
            console.error( error );
        } );
</script>




@endpush