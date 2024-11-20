
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
                        <h5 class="m-b-10">SMS</h5>
                    </div>
                    <ul class="breadcrumb">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('admin.smsroutes.index') }}">Home</a></li> -->
                        <li class="breadcrumb-item">Create</li>
                    </ul>
                </div>
                <!-- <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.smsroutes.index') }}" class="btn btn-outline-primary d-flex align-items-center">
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
                </div> -->
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card border-top-0">
                            <!-- <div class="card-header p-0">
                               
                                <ul class="nav nav-tabs flex-wrap w-100 text-center customers-nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item flex-fill border-top" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link active" data-bs-toggle="tab" data-bs-target="#profileTab" role="tab">Profile</a>
                                    </li>
                                    <li class="nav-item flex-fill border-top" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab" data-bs-target="#passwordTab" role="tab">Bank Information</a>
                                    </li>
                                  
                                </ul>
                            </div> -->
                            <div class="tab-content">
                                
                                <div class="tab-pane fade show active" id="profileTab" role="tabpanel">
                                    <div class="card-body personal-info">

                                    <form action="{{ $smsroute ? route('admin.smsroutes.update', $smsroute->id) : route('admin.smsroutes.store') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        @if($smsroute)
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
                                                <span class="d-block mb-2">SMS Information:</span>
                                                <!-- <span class="fs-12 fw-normal text-muted text-truncate-1-line">Following information is publicly displayed, be careful! </span> -->
                                            </h5>
                                        </div>
                                       
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label class="fw-semibold">Customer: </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select class="form-control @error('customer_id') is-invalid @enderror" data-select2-selector="tag" name="customer_id" id="customer_id">
                                                    @if(count($customerlist) > 0)
                                                        <option value="">Select Customer</option>
                                                        @foreach($customerlist as $customer)
                                                            <option value="{{ $customer->id }}" @if(isset($smsroute) && $smsroute->customer_id == $customer->id) selected @endif>{{ ucfirst($customer->first_name) }} {{ ucfirst($customer->last_name) }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value=''>No Customer found</option>
                                                    @endif
                                                </select>
                                                @error('customer_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="fullnameInput" class="fw-semibold">Description (Trunk): </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <textarea class="form-control"
                                                    id="" name="customer_description"  id="addressInput_2" cols="30" rows="3" placeholder="Customer Trunk">{{ isset($smsroute->customer_description) && !empty($smsroute->customer_description) ? $smsroute->customer_description : ''}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label class="fw-semibold">Vendor: </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select class="form-control @error('vendor_id') is-invalid @enderror" data-select2-selector="tag" name="vendor_id" id="vendor_id">
                                                    @if(count($vendorlist) > 0)
                                                        <option value="">Select Vendor</option>
                                                        @foreach($vendorlist as $vendor)
                                                            <option value="{{ $vendor->id }}" @if(isset($smsroute) && $smsroute->vendor_id == $vendor->id) selected @endif>{{ ucfirst($vendor->first_name) }} {{ ucfirst($vendor->last_name) }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value=''>No Vendor found</option>
                                                    @endif
                                                </select>
                                                @error('vendor_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="fullnameInput" class="fw-semibold">Description (Trunk): </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <textarea class="form-control"
                                                    id="" name="vendor_description"  id="addressInput_2" cols="30" rows="3" placeholder="Vendor Trunk">{{ isset($smsroute->vendor_description) && !empty($smsroute->vendor_description) ? $smsroute->vendor_description : ''}}</textarea>
                                                </div>
                                            </div>
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

    ClassicEditor.create( document.querySelector( '#editor2' ) )
    .catch( error => {
        console.error( error );
    } );
</script>

<!-- <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1');
</script> -->
@endpush