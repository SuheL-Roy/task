@extends('master\master')
@section('title')
    {{ __('Project List') }}
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
                                    data-bs-target="#exampleModalLive">Create Project</button>
                            </div>
                            <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLiveLabel">Create Project</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>


                                        <form id="registerForm" action="{{ route('Project.project_store') }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <?php
                                                use App\Models\Project;
                                                $count = count(Project::whereDate('created_at', date('Y-m-d'))->get());
                                                $s = $count + 1;
                                                $code = date('Ymd') . $s;
                                                
                                                ?>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="text" required class="form-control mt-2"
                                                            name="project_code" id="name"
                                                            value="PRJ-{{ $code }}"
                                                            placeholder="Enter your project code" readonly>
                                                        <span class="text-danger error-message" id="nameError"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="text" required class="form-control mt-2"
                                                            name="name" id="name" placeholder="Enter your name"
                                                            required>
                                                        <span class="text-danger error-message" id="nameError"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="text" required class="form-control mt-2"
                                                            name="description" placeholder="Enter your Description">
                                                        <span class="text-danger error-message" id="emailError"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="date" required class="form-control mt-2"
                                                            name="deadline" id="email" value="{{ date('Y-m-d') }}"
                                                            required>
                                                        <span class="text-danger error-message" id="emailError"></span>
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
                                            <th>Project Code</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->project_code }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    <a href="{{ route('Project.delete', ['id' => $item->id]) }}"
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
@endsection
