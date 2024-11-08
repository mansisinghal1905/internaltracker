
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
                        <h5 class="m-b-10">New Interconnection</h5>
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

                                    <form action="{{ $task ? route('admin.tasks.update', $task->id) : route('admin.newinterconnections.store') }}" method="POST" enctype="multipart/form-data">
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
                                                <span class="d-block mb-2">New Interconnection:</span>
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
                                                        <label class="fw-semibold">Customer: </label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <select class="form-control @error('customer_id') is-invalid @enderror" data-select2-selector="tag" name="customer_id" id="customer_id">
                                                            @if(count($customerlist) > 0)
                                                                <option value="">Select Customer</option>
                                                                @foreach($customerlist as $customer)
                                                                    <option value="{{ $customer->id }}" @if(isset($route) && $route->customer_id == $customer->id) selected @endif>{{ ucfirst($customer->first_name) }} {{ ucfirst($customer->last_name) }}</option>
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
                                                        <label for="fullnameInput" class="fw-semibold"> Company Name: </label>
                                                    </div>
                                                    <div class="col-lg-8"> 
                                                        <div class="input-group">
                                                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ isset($task->company_name) && !empty($task->company_name) ? $task->company_name : ''}}" id="fullnameInput" placeholder="Company Name">
                                                        </div>
                                                        @error('company_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                              
                                                <div class="row mb-4 align-items-center">
                                                    <div class="col-lg-4">
                                                        <label class="fw-semibold">Country: </label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <!-- <label class="fw-semibold">Country: </label> -->
                                                        <select class="form-control @error('register_country_id') is-invalid @enderror" data-select2-selector="tag" name="register_country_id" id="country_id">
                                                            @if(count($countrylist) > 0)
                                                                <option value="" >Select Country</option>
                                                                        @if($countrylist)
                                                                            @foreach($countrylist as $id=> $des)
                                                                            <option value="{{$des->id}}" @if(isset($task) &&  in_array($des->id, explode(",",$task->register_country_id))) selected @endif>{{ ucfirst($des->name) }}</option>
                                                                            @endforeach
                                                                        @endif
                                                            @else
                                                                <option value=''>No Country found</option>
                                                            @endif
                                                        </select>
                                                        @error('register_country_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-4 align-items-center">
                                                        <div class="col-lg-4">
                                                            <label for="fullnameInput" class="fw-semibold"> AM Name: </label>
                                                        </div>
                                                        <div class="col-lg-8"> 
                                                            <div class="input-group">
                                                                <input type="text" name="am_name" class="form-control @error('am_name') is-invalid @enderror"  value="{{ isset($task->am_name) && !empty($task->am_name) ? $task->am_name : ''}}" id="fullnameInput" placeholder="AM Name">
                                                            </div>
                                                            @error('am_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                </div>

                                                <div class="row mb-4 align-items-center">
                                                    <div class="col-lg-4">
                                                        <label for="fullnameInput" class="fw-semibold"> AM Email: </label>
                                                    </div>
                                                    <div class="col-lg-8"> 
                                                        <div class="input-group">
                                                            <input type="text" name="am_email" class="form-control @error('am_email') is-invalid @enderror" value="{{ isset($task->am_email) && !empty($task->am_email) ? $task->am_email : ''}}" id="fullnameInput" placeholder="AM Email">
                                                        </div>
                                                        @error('am_email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-4 align-items-center">
                                                    <div class="col-lg-4">
                                                        <label for="fullnameInput" class="fw-semibold"> AM Skype/Whatsapp: </label>
                                                    </div>
                                                    <div class="col-lg-8"> 
                                                        <div class="input-group">
                                                            <input type="text" name="whatsapp_no" class="form-control @error('whatsapp_no') is-invalid @enderror" value="{{ isset($task->whatsapp_no) && !empty($task->whatsapp_no) ? $task->whatsapp_no : ''}}" id="fullnameInput" placeholder="AM Skype/Whatsapp">
                                                        </div>
                                                        @error('whatsapp_no')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-4 align-items-center">
                                                    <div class="col-lg-4">
                                                        <label for="fullnameInput" class="fw-semibold"> Registered Year: </label>
                                                    </div>
                                                    <div class="col-lg-8"> 
                                                        <div class="input-group">
                                                            <input type="text" name="register_year" class="form-control @error('register_year') is-invalid @enderror" value="{{ isset($task->register_year) && !empty($task->register_year) ? $task->register_year : ''}}" id="fullnameInput" placeholder="Register Year">
                                                        </div>
                                                        @error('register_year')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-4 align-items-center">
                                                    <div class="col-lg-4">
                                                        <label for="fullnameInput" class="fw-semibold">Description: </label>
                                                    </div>
                                                    <div class="col-lg-8" id="dynamicTextboxWrapper">
                                                    @if(isset($taskDescriptions) && count($taskDescriptions) > 0)
                                                    @foreach($taskDescriptions as $description)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="description[]" class="form-control" placeholder="Description" value="{{ isset($description->description) && !empty($description->description) ? $description->description : ''}}">
                                                            <button type="button" class="btn btn-danger remove-field " style="display:none;">Remove</button>
                                                        </div>
                                                    @endforeach
                                                    @else
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="description[]" class="form-control" placeholder="Description">
                                                            <button type="button" class="btn btn-danger remove-field" style="display:none;">Remove</button>
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <!-- <div class="col-lg-12 text-end"> -->
                                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                                        <button type="button" id="addMoreButton" class="btn btn-success text-end">Add More</button>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var max_fields = 10; // Maximum number of input fields
        var wrapper = $("#dynamicTextboxWrapper"); // Wrapper for dynamic input fields
        var add_button = $("#addMoreButton"); // Add button
        var field_count = 1; // Initial field count

        $(add_button).click(function(e) {
            e.preventDefault();
            if (field_count < max_fields) { // Check max fields
                field_count++;
                $(wrapper).append(`
                    <div class="input-group mb-2">
                        <label for="inputField${field_count}"></label>
                        <input type="text" name="description[]" class="form-control" placeholder="Description">
                        <button type="button" class="btn btn-danger remove-field">Remove</button>
                    </div>
                `);
            }
        });

        // Remove input field
        $(wrapper).on("click", ".remove-field", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            field_count--;
        });
    });
</script>



@endpush