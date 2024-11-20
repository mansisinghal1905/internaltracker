
@extends('admin.layouts.backend.app')

@section('content')
<main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Test Result</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.testresults.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Create</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.testresults.index') }}" class="btn btn-outline-primary d-flex align-items-center">
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

                                    <form action="{{ route('admin.testresults.store') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                       
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
                                                <span class="d-block mb-2">Test Result:</span>
                                               
                                            </h5>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="titleInput" class="fw-semibold">Network Name: </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                   
                                                    <input type="text" class="form-control" name="network_name" value="" id="titleInput" placeholder="Network Name">
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="titleInput" class="fw-semibold">Result: </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                <input type="text" class="form-control" name="result" value="" id="titleInput" placeholder="Result">

                                               
                                                   
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="titleInput" class="fw-semibold">Test By User: </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                   
                                                    <input type="text" class="form-control" name="test_by_user" value="" id="titleInput" placeholder="Test By User">
                                                </div>
                                               
                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="titleInput" class="fw-semibold">Date: </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                   
                                                    <input type="date" class="form-control" name="date" value="" id="titleInput" placeholder="Test By User">
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="titleInput" class="fw-semibold">Note: </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                   
                                                <textarea class="form-control" id="" name="note"  id="addressInput_2" cols="30" rows="3" placeholder="Note"></textarea>
                                                </div>
                                               
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>

                                    </div>
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
   

@endpush