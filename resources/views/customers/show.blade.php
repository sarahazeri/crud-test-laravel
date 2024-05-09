@extends('customers.layouts')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Customer Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('customers.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>First
                                Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $customer->getFirstName() }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Last
                                Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $customer->getLastName() }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end text-start"><strong>Date Of
                                Birth:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $customer->getDateOfBirth() }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start"><strong>Phone
                                Number:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $customer->getFullPhoneNumber() }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Email:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $customer->getEmail() }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>Bank
                                Account Number:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $customer->getBankAccountNumber() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
