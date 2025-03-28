@extends('master\master')
@section('title')
    {{ __('Task List') }}
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
                                <li class="breadcrumb-item" aria-current="page">Task List</li>
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
                            <form action="{{ route('task.create_task_assign_list') }}" method="GET">
                                @csrf
                                <div class="col-sm-10 d-flex align-items-center">

                                    <div class="col-sm-3 p-sm-2">

                                    </div>
                                    <div class="col-sm-3 p-sm-2">
                                        <label for="project" class="form-label"></label>
                                        <select class="form-select project_id @error('project_id') is-invalid @enderror"
                                            name="project_id" required>
                                            <option value="">Select Project</option>
                                            @foreach ($projects as $item)
                                                <option {{ $item->id == $project_id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">
                                                    {{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>



                                    <div class="col-sm-3 p-sm-2">
                                        <label for="status" class="form-label"></label>
                                        <select class="form-select" name="status" id="status" required>
                                            <option selected>Select Status</option>
                                            <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Working" {{ $status == 'Working' ? 'selected' : '' }}>Working
                                            </option>
                                            <option value="Done" {{ $status == 'Done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3 p-sm-2">
                                        <button type="submit" class="btn btn-primary mt-4">
                                            Filter
                                        </button>
                                    </div>

                                </div>
                            </form>
                            @if (auth()->user()->role === 'Manager')
                                <div class="text-end p-sm-4 pb-sm-2">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLive">Create Task</button>
                                </div>
                            @endif
                            <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLiveLabel">Create Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>


                                        <form id="registerForm" action="{{ route('task.task_store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12 pb-1">
                                                        <select
                                                            class="form-select project_id @error('project_id') is-invalid @enderror"
                                                            name="project_id" required>
                                                            <option value="">Select Project</option>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}</option>
                                                            @endforeach

                                                        </select>
                                                        @error('project')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12 mt-2" style="position: relative; z-index: 999;">
                                                        {{-- <select
                                                            class="form-select teammates_id @error('teammates_id') is-invalid @enderror"
                                                            name="teammates_id" required>
                                                            <option value="">Assigned Teammates</option>
                                                            @foreach ($teammates as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}</option>
                                                            @endforeach

                                                        </select> --}}
                                                        <select id="teammates_id"
                                                           
                                                            class="form-select @error('teammates_id') is-invalid @enderror"
                                                           name="teammates_id[]" multiple required>
                                                            <option value="">Assigned Teammates</option>
                                                            @foreach ($teammates as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>



                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="text" required class="form-control mt-2"
                                                            name="task_name" id="name" placeholder="Enter your name">
                                                        <span class="text-danger error-message" id="nameError"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="text" required class="form-control mt-2"
                                                            name="task_description" id="email"
                                                            placeholder="Enter your Description">
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
                                            <th>Project Name</th>
                                            <th>Task Name</th>
                                            <th>Task Description</th>
                                            <th>Assigned Teammates Name</th>
                                            <th style="width: 14%;">Status</th>
                                            @if (auth()->user()->role === 'Manager')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task_assigns_list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->project_name }}</td>
                                                <td>{{ $item->task_name }}</td>
                                                <td>{{ $item->task_description }}</td>
                                                <td>{{ $item->users_name }}</td>
                                                <td><select title="{{ $item->id }}" name="status"
                                                        class="form-control STU">
                                                        <option value="">{{ $item->status }}</option>

                                                        @if ($item->status != 'Working' && $item->status != 'Done')
                                                            <option value="Working">Working</option>
                                                        @endif

                                                        @if ($item->status != 'Done')
                                                            <option value="Done">Done</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                @if (auth()->user()->role === 'Manager')
                                                    <td>
                                                        <a href="{{ route('task.destroy', ['id' => $item->id]) }}"
                                                            class="btn btn-primary">

                                                            Delete
                                                        </a>
                                                    </td>
                                                @endif
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


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('change', '.STU', function() {
            var id = $(this).attr("title");
            var value = $(this).val();


            if (!confirm('You Want to Change Status to "' + value + '" ?')) {

                $(this).val($(this).data('previous'));
                return;
            }


            $.ajax({
                type: 'GET',
                url: '{{ route('task.task_status_update') }}',
                data: {
                    id: id,
                    status: value
                },
                success: function(data) {
                    location.reload();
                }
            });
        });


        $(document).on('focus', '.STU', function() {
            $(this).data('previous', $(this).val());
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const teammatesSelect = new Choices('#teammates_id', {
                removeItemButton: true,
                searchEnabled: false,
            });

            document.getElementById('teammates_id').addEventListener('change', function() {
                teammatesSelect.hideDropdown();
            });
        });
    </script>
@endsection
