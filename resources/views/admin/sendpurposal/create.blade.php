
@extends('admin.layouts.backend.app')
@push('style')

@Endpush
@section('content')
<main class="nxl-container">
        <div class="nxl-content">
          
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                   
                    <div class="col-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <form action="{{ $quotationmail ? route('admin.quotationmail.update', $quotationmail->id) : route('admin.quotationmail.store') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        @if($quotationmail)
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
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-4">
                                                <h5 class="fw-bold">Quotation Information:</h5>
                                                <span class="fs-12 text-muted">Add items to Quotation</span>
                                            </div>  
                                        </div>
                                    </div>
                                   

                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Client: </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-control @error('client_id') is-invalid @enderror" name="client_id" data-select2-selector="country">
                                            @if(count($clientlist) > 0)
                                                    <option value="" >Select Client</option>
                                                    @foreach($clientlist as $client)
                                                        
                                                        <!-- <option value="{{ $client->id }}" @if(isset($quotationmail) && in_array($client->id, $quotationmail->client_id ?? [])) selected @endif>{{ ucfirst($client->name) }}</option> -->
                                                        <option value="{{ $client->id }}" @if(isset($quotationmail) && in_array($client->id, $quotationmail)) selected @endif>{{ ucfirst($client->name) }}</option>
                                                    
                                                    @endforeach
                                                @else
                                                    <option value=''>No Client found</option>
                                                @endif
                                            </select>
                                            @error('client_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Quotation: </label>
                                        </div>
                                        <div class="col-lg-8">

                                            <select class="form-control @error('quotation_id') is-invalid @enderror" name="quotation_id" data-select2-selector="country">
                                            @if(count($quotationlist) > 0)
                                                    <option value="" >Select Quotation</option>
                                                    @foreach($quotationlist as $quotation)
                                                        
                                                    <option value="{{ $quotation->id }}" @if(isset($quotationmail) && $quotationmail->quotation_id == $quotation->id) selected @endif>{{ ucfirst($quotation->quotation_subject) }}</option>
                                                        
                                                    @endforeach
                                                @else
                                                    <option value=''>No Quotation found</option>
                                                @endif
                                            </select>
                                            @error('quotation_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </main>
@endsection
@push('script')

    
    
@endpush