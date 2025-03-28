@extends('master\master')
@section('title')
    {{ __('Assign Project List') }}
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
                            <form action="{{ route('Project.project_wise_task_filter') }}" method="GET">
                                @csrf
                                <div class="col-sm-10 d-flex align-items-center">

                                    <div class="col-sm-2 p-sm-2">

                                    </div>
                                    <div class="col-sm-3 p-sm-2">
                                        <label for="project" class="form-label"></label>
                                        <select class="form-select project_id @error('project_id') is-invalid @enderror"
                                            name="project_id" required>
                                            <option value="">Select Project</option>
                                            @foreach ($projects as $item)
                                                <option {{ $item->id == $project_id ? 'selected' : '' }} value="{{ $item->id }}">
                                                    {{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-sm-3 p-sm-2">
                                        <label for="teammate" class="form-label"></label>
                                        <select class="form-select teammates_id @error('teammates_id') is-invalid @enderror"
                                            name="teammates_id" required>
                                            <option value="">Select Teammates</option>
                                            @foreach ($teammates as $item)
                                                <option {{ $item->id == $teammates_id ? 'selected' : '' }} value="{{ $item->id }}">
                                                    {{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-sm-3 p-sm-2">
                                        <label for="status" class="form-label"></label>
                                        <select class="form-select" name="task_id" id="status">
                                            <option selected>Select Task</option>
                                            @foreach ($task_list as $item)
                                                <option {{ $item->id == $task_id ? 'selected' : '' }} value="{{ $item->id }}">
                                                    {{ $item->task_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3 p-sm-2">
                                        <button type="submit" class="btn btn-primary mt-4">
                                            Filter
                                        </button>
                                    </div>

                                </div>
                            </form>

                           
                            <div class="table-responsive">
                                <table class="table table-hover tbl-product" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Project Code</th>
                                            <th>Project Name</th>
                                            <th>Task Name</th>
                                            <th>Teammates Name</th>
                                            <th>Status</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project_wise_task_assigns_list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->project_code }}</td>
                                                <td>{{ $item->project_name}}</td>
                                                <td>{{ $item->task_name }}</td>
                                                <td>{{ $item->users_name }}</td>
                                                <td>{{ $item->status }}</td>
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
