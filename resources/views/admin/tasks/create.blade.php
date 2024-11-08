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
               <h5 class="m-b-10">Task</h5>
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
                  <div class="card-header p-0">
                     <!-- Nav tabs -->
                     <form action="{{ $task ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
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
                            <ul class="nav nav-tabs flex-wrap w-100 text-center customers-nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item flex-fill border-top" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link active" id="profileTabLink" data-bs-toggle="tab" data-bs-target="#profileTab" role="tab">New InterConnection</a>
                                </li>
                                <li class="nav-item flex-fill border-top" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link" id="passwordTabLink" data-bs-toggle="tab" data-bs-target="#passwordTab" role="tab">Trade Verification</a>
                                </li>
                                <li class="nav-item flex-fill border-top" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link" id="billingTabLink" data-bs-toggle="tab" data-bs-target="#billingTab" role="tab">Agreement Review</a>
                                </li>
                                <li class="nav-item flex-fill border-top" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link" id="subscriptionTabLink" data-bs-toggle="tab" data-bs-target="#subscriptionTab" role="tab">Agreement Signing</a>
                                </li>
                            </ul>
                  </div>
                  
                        <div class="tab-content">
                        <!-- <form action="{{ $task ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
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
                              @endif -->
                            <div class="tab-pane fade show active" id="profileTab" role="tabpanel">
                                <div class="card-body personal-info">
                                
                                    <div class="mb-4 d-flex align-items-center justify-content-between">
                                        <h5 class="fw-bold mb-0 me-4">
                                            <span class="d-block mb-2">Task Information:</span>
                                        </h5>
                                    </div>
                                    <div class="tab-pane fade show active" id="profileTab" role="tabpanel">
                                        <div class="card-body personal-info">
                                            <div class="mb-4 d-flex align-items-center justify-content-between">
                                            <h5 class="fw-bold mb-0 me-4">
                                                <span class="d-block mb-2">New Interconnection:</span>
                                            </h5>
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
                                    </div>
                                    
                                    <!-- End section -->
                                <!-- </form> -->

                                    <div class="mt-3">
                                        <button id="nextBtn" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Bank Detail -->
                            <div class="tab-pane fade" id="passwordTab" role="tabpanel">
                                <div class="card-body pass-info">
                                <div class="mb-4 d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold mb-0 me-4">
                                        <span class="d-block mb-2">Trade Verification:</span>
                                    </h5>
                                </div>
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
                                    <div class="mt-3">
                                        <button id="prevBtn" class="btn btn-secondary">Back</button>
                                        <button id="nextBtn1" class="btn btn-primary">Next</button>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="billingTab" role="tabpanel">
                                <div class="card-body pass-info">
                                <div class="mb-4 d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold mb-0 me-4">
                                        <span class="d-block mb-2">Agreement Review:</span>
                                    </h5>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="fullnameInput" class="fw-semibold">Description: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <textarea class="form-control"
                                            id="" name="review_description"  id="addressInput_2" placeholder="Description">{{ isset($agreementreview->review_description) && !empty($agreementreview->review_description) ? $agreementreview->review_description : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="fullnameInput" class="fw-semibold"> Billing Cycle: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <input type="text" name="billing_cycle_review" class="form-control" value="{{ isset($agreementreview->billing_cycle_review) && !empty($agreementreview->billing_cycle_review) ? $agreementreview->billing_cycle_review : ''}}" id="fullnameInput" placeholder="Billing Cycle">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="fullnameInput" class="fw-semibold"> Financial Statement: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <input type="text" name="financial_statement" class="form-control" value="{{ isset($agreementreview->financial_statement) && !empty($agreementreview->financial_statement) ? $agreementreview->financial_statement : ''}}" id="fullnameInput" placeholder="Financial Statement">
                                        </div>
                                    </div>
                                </div>
                                </div>
                                    <div class="mt-3">
                                        <button id="prevBtn1" class="btn btn-secondary">Back</button>
                                        <button id="nextBtn2" class="btn btn-primary">Next</button>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="subscriptionTab" role="tabpanel">
                                <div class="card-body pass-info">
                                <div class="mb-4 d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold mb-0 me-4">
                                        <span class="d-block mb-2">Agreement Signing:</span>
                                    </h5>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="agreementSignYes" class="fw-semibold">Agreement:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="agreement" id="agreementSignYes" value="yes" 
                                            {{ isset($agreementsign->agreement) && $agreementsign->agreement === 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="agreementSignYes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="agreement" id="agreementSignNo" value="no" 
                                            {{ isset($agreementsign->agreement) && $agreementsign->agreement === 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="agreementSignNo">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="agreementSignYes" class="fw-semibold">Unilateral/Bilateral:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="unilateral" id="agreementSignYes" value="unilateral" 
                                            {{ isset($agreementsign->unilateral) && $agreementsign->unilateral === 'unilateral' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="agreementSignYes">Unilateral</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="unilateral" id="agreementSignNo" value="bilateral" 
                                            {{ isset($agreementsign->unilateral) && $agreementsign->unilateral === 'bilateral' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="agreementSignNo">Bilateral</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="fullnameInput" class="fw-semibold">Description: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <textarea class="form-control"
                                            id="" name="sign_description"  id="addressInput_2" placeholder="Description">{{ isset($agreementsign->sign_description) && !empty($agreementsign->sign_description) ? $agreementsign->sign_description : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="mt-3">
                                    <button id="prevBtn2" class="btn btn-secondary">Back</button>
                                   
                                </div>
                            </div>
                            
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                    
                        </div>
                        </form> 
                  
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


<script>
  const tabs = [...document.querySelectorAll('.nav-link')];
  let currentTabIndex = 0;

    document.getElementById('nextBtn').addEventListener('click', () => {
        if (currentTabIndex < tabs.length - 1) {
        currentTabIndex++;
        tabs[currentTabIndex].click();
        }
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentTabIndex > 0) {
        currentTabIndex--;
        tabs[currentTabIndex].click();
        }
    });

    document.getElementById('nextBtn1').addEventListener('click', () => {
        if (currentTabIndex < tabs.length - 1) {
        currentTabIndex++;
        tabs[currentTabIndex].click();
        }
    });

    document.getElementById('prevBtn1').addEventListener('click', () => {
        if (currentTabIndex > 0) {
        currentTabIndex--;
        tabs[currentTabIndex].click();
        }
    });

    document.getElementById('nextBtn2').addEventListener('click', () => {
        if (currentTabIndex < tabs.length - 1) {
        currentTabIndex++;
        tabs[currentTabIndex].click();
        }
    });
    document.getElementById('prevBtn2').addEventListener('click', () => {
        if (currentTabIndex > 0) {
        currentTabIndex--;
        tabs[currentTabIndex].click();
        }
    });
</script>
@endpush