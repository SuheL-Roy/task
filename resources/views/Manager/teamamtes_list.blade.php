@extends('master\master')
@section('title')
    {{ __('Teammates List') }}
@endsection
@section('content')
    <div class="pc-container">

        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Teammates List</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-body">
                            <div class="text-end p-sm-4 pb-sm-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalLive">Create Teammates</button>
                            </div>
                            <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLiveLabel">Create Teammates</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>


                                        <form id="registerForm" action="{{ route('manager.teammates_store') }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="text" required class="form-control mt-2"
                                                            name="name" id="name" placeholder="Enter your name">
                                                        <span class="text-danger error-message" id="nameError"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="email" required class="form-control mt-2"
                                                            name="email" id="email" placeholder="Enter your email">
                                                        <span class="text-danger error-message" id="emailError"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="password" required minlength="8"
                                                            class="form-control mt-2" name="password" id="password"
                                                            placeholder="Enter your password">
                                                        <span class="text-danger error-message" id="passwordError"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="password" required class="form-control mt-2"
                                                            name="password_confirmation" id="password_confirmation"
                                                            placeholder="Confirm your password">
                                                        <span class="text-danger error-message"
                                                            id="confirmPasswordError"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover tbl-product" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teammates as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->role }}</td>
                                                <td>
                                                    <a href="{{ route('manager.destroy', ['id' => $item->id]) }}"
                                                        class="btn btn-primary">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#registerForm").submit(function(event) {
                event.preventDefault(); // Prevent form submission

                // Clear previous error messages
                $(".error-message").text("");

                let isValid = true;
                let name = $("#name").val();
                let email = $("#email").val();
                let password = $("#password").val();
                let confirmPassword = $("#password_confirmation").val();

                // Name validation
                if (name.trim() === "") {
                    $("#nameError").text("Name is required.");
                    isValid = false;
                }

                // Email validation
                let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
                if (!email.match(emailPattern)) {
                    $("#emailError").text("Enter a valid email address.");
                    isValid = false;
                }

                // Password validation
                if (password.length < 8) {
                    $("#passwordError").text("Password must be at least 8 characters.");
                    isValid = false;
                }

                // Confirm password validation
                if (confirmPassword !== password) {
                    $("#confirmPasswordError").text("Passwords do not match.");
                    isValid = false;
                }

                // If everything is valid, submit the form
                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
