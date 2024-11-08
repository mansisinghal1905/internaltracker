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
      <div class="container mt-4">
    <!-- Step navigation -->
    <ul class="nav nav-tabs" id="stepTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="step1-tab" data-bs-toggle="tab" data-bs-target="#step1" type="button" role="tab" aria-controls="step1" aria-selected="true">Step 1</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">Step 2</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">Step 3</button>
        </li>
    </ul>

    <!-- Tab panes (steps) -->
    <div class="tab-content mt-4">
        <!-- Step 1 -->
        <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
            <div class="card-body personal-info">
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 me-4">
                        <span class="d-block mb-2">Task Information:</span>
                    </h5>
                </div>
                
                <!-- Company Name -->
                <div class="row mb-4 align-items-center">
                    <div class="col-lg-4">
                        <label for="fullnameInput" class="fw-semibold">Company Name: </label>
                    </div>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ isset($task->company_name) ? $task->company_name : ''}}" id="fullnameInput" placeholder="Company Name">
                        </div>
                        @error('company_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Country -->
                <div class="row mb-4 align-items-center">
                    <div class="col-lg-4">
                        <label class="fw-semibold">Country: </label>
                    </div>
                    <div class="col-lg-8">
                        <select class="form-control @error('register_country_id') is-invalid @enderror" name="register_country_id" id="country_id">
                            @if(count($countrylist) > 0)
                            <option value="">Select Country</option>
                            @foreach($countrylist as $id => $des)
                            <option value="{{$des->id}}" @if(isset($task) && in_array($des->id, explode(",", $task->register_country_id))) selected @endif>{{ ucfirst($des->name) }}</option>
                            @endforeach
                            @else
                            <option value=''>No Country found</option>
                            @endif
                        </select>
                        @error('register_country_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Step 1 Navigation -->
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button class="btn btn-primary" id="nextStep1">Next</button>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
            <div class="card-body personal-info">
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 me-4">
                        <span class="d-block mb-2">New Interconnection:</span>
                    </h5>
                </div>
                
                <!-- AM Name -->
                <div class="row mb-4 align-items-center">
                    <div class="col-lg-4">
                        <label for="fullnameInput" class="fw-semibold">AM Name: </label>
                    </div>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <input type="text" name="am_name" class="form-control @error('am_name') is-invalid @enderror" value="{{ isset($task->am_name) ? $task->am_name : ''}}" id="fullnameInput" placeholder="AM Name">
                        </div>
                        @error('am_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Step 2 Navigation -->
                <div class="d-flex justify-content-between gap-2 mt-3">
                    <button class="btn btn-secondary" id="prevStep2">Previous</button>
                    <button class="btn btn-primary" id="nextStep2">Next</button>
                </div>
            </div>
        </div>
                <!-- Step 2 -->
                <div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab">
            <div class="card-body personal-info">
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 me-4">
                        <span class="d-block mb-2">New Interconnection:</span>
                    </h5>
                </div>
                
                <!-- AM Name -->
                <div class="row mb-4 align-items-center">
                    <div class="col-lg-4">
                        <label for="fullnameInput" class="fw-semibold">AM Name: </label>
                    </div>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <input type="text" name="am_name" class="form-control @error('am_name') is-invalid @enderror" value="{{ isset($task->am_name) ? $task->am_name : ''}}" id="fullnameInput" placeholder="AM Name">
                        </div>
                        @error('am_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Step 2 Navigation -->
                <div class="d-flex justify-content-between gap-2 mt-3">
                    <button class="btn btn-secondary" id="prevStep2">Previous</button>
                    <button class="btn btn-primary" id="nextStep3">Next</button>
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


<script>
    // JavaScript to navigate steps
    document.getElementById('nextStep1').addEventListener('click', function () {
        var step2Tab = new bootstrap.Tab(document.querySelector('#step2-tab'));
        step2Tab.show();
    });
    
    document.getElementById('prevStep2').addEventListener('click', function () {
        var step1Tab = new bootstrap.Tab(document.querySelector('#step1-tab'));
        step1Tab.show();
    });

    document.getElementById('nextStep2').addEventListener('click', function () {
        var step3Tab = new bootstrap.Tab(document.querySelector('#step3-tab'));
        step2Tab.show();
    });
</script>
@endpush