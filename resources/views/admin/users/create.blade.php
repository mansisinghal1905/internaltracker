
@extends('admin.layouts.backend.app')

@section('content')
<main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Clients</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Create</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary d-flex align-items-center">
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

                                    <form action="{{ $user ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        @if($user)
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
                                                <span class="d-block mb-2">Personal Information:</span>
                                                <span class="fs-12 fw-normal text-muted text-truncate-1-line">Following information is publicly displayed, be careful! </span>
                                            </h5>
                                        </div>
                                       
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="imageUpload" class="fw-semibold">Upload Image:</label>
                                                <div class="input-group">
                                                    <div id="image_preview">
                                                    @if(isset($user) && $user->avatar != null)
                                                        <img height="50" width="50" id="previewing" src="{{ asset($user->avatar) }}" alt="User Avatar">
                                                    @else
                                                        <img height="50" width="50" id="previewing" src="{{ asset('public/assets/images/no-image-available.png')}}" alt="">
                                                    @endif
                                                    </div>
                                                    <input type="file" id="file" name="avatar" accept=".jpg, .jpeg, .png" class="form-control">
                                                </div>
                                               
                                                <!-- <img src="{{ isset($user->avatar) && !empty($user->avatar) ? $user->avatar : ''}} " style="width:80px;margin-top: 10px;"> -->
                                            </div>
                                        
                                            <div class="col-lg-4">
                                                <label for="fullnameInput" class="fw-semibold">First Name: </label>
												 <div class="input-group">
                                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ isset($user->first_name) && !empty($user->first_name) ? $user->first_name : ''}}" id="firstnameInput" placeholder="First Name">
                                                </div>
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="fullnameInput" class="fw-semibold">Last Name: </label>
												 <div class="input-group">
                                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ isset($user->last_name) && !empty($user->last_name) ? $user->last_name : ''}}" id="lastnameInput" placeholder="Last Name">
                                                </div>
                                                @error('last_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>	
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                        
                                            <div class="col-lg-4">
                                                <label for="fullnameInput" class="fw-semibold">Email: </label>
                                                <div class="input-group">
                                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($user->email) && !empty($user->email) ? $user->email : ''}}" id="mailInput" placeholder="Email">
                                                </div>
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="fullnameInput" class="fw-semibold">Mobile: </label>
                                                <div class="input-group">
                                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ isset($user->phone_number) && !empty($user->phone_number) ? $user->phone_number : ''}}" id="phoneInput" placeholder="Phone">
                                                </div>
                                                @error('phone_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>  
                                            <div class="col-lg-4">
                                                <label for="fullnameInput" class="fw-semibold">Date Of Birth: </label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" name="dob" value="{{ isset($user->dob) && !empty($user->dob) ? $user->dob : ''}}" id="companyInput" placeholder="Date Of Birth">
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script> -->
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#country_id').select2({
            placeholder: 'Select country', // Your placeholder text here
        });
        $('#state_id').select2({
            placeholder: 'Select state', // Your placeholder text here
        });
        $('#city_id').select2({
            placeholder: 'Select city', // Your placeholder text here
        });
        //Country 
         $("#country_id").change(function() {
            selectedValues = [];
            selectedValues.push($(this).val());
            data = {
                selectedValues:selectedValues
            };
            url = "{{route('admin.getStatelistByCountryId')}}";
            id = "#state_id";
            SelectChangeValue(data,url,id,null);


            selectedValues = [];
            selectedValues.push(0);
            data = {
                selectedValues:selectedValues
            };
            url = "{{route('admin.getCitylistByStateId')}}";
            id = "#city_id";
            SelectChangeValue(data,url,id,null);


           
        });
        //State 
         $("#state_id").change(function() {
            selectedValues = [];
            selectedValues.push($(this).val());
            data = {
                selectedValues:selectedValues
            };
            url = "{{route('admin.getCitylistByStateId')}}";
            id = "#city_id";
            SelectChangeValue(data,url,id,null);

           
        });
        
        function SelectChangeValue(data,url,id,selectedId){
            valuesArray = null;
            if(selectedId!=null)
            {
                valuesArray = selectedId.split(",");
            }
            options="";
              $.ajax({
                type: 'post',
                url: url,
                data: data,
                dataType: "json",
                cache: false,
              //  mimeType: "multipart/form-data",
                //processData: false,
                //contentType: false,
            })
            .done(function(data) {
                if (data.status == true) {
                  
                  var result = data.data;
                  var select_option = ''; 
                  if (id === '#country_id') {
                    select_option = 'Select Country'; 
                  }else if(id === '#state_id'){
                    select_option = 'Select State'; 
                  }else if(id === '#city_id'){
                    select_option = 'Select City'; 
                  }else{
                    select_option = 'Select Region'; 
                  }
                  options="<option selected  value=''>"+select_option+"</option>";
                  
                  $.each(result, function(key,val) {
                    /*if($.inArray(val.id, valuesArray) !== -1)
                    {
                        options+="<option value='"+val.id+"'>"+val.name+"</option>";
                    }
                    else{*/
                     options+="<option  value='"+val.id+"'>"+val.name+"</option>";   
                    /*}*/
                  });
                }
                  $(id).html(options);

            });
        }
    })
</script>

@endpush