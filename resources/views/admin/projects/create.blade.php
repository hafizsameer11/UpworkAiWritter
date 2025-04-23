@extends('admin.layout')

@section('adminMain')
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h5 class="mb-0">Create New Project</h5>
                </div>
                <div class="card-body">
                    <form id="createProjectForm">
                        <div class="form-group">
                            <label for="niche_id">Niche ID</label>
                            <select name="niche_id" id="niche_id" class="form-control">
                                <option value="">Select Niche</option>
                                @foreach ($niches as $niche)
                                    <option value="{{$niche->id}}">{{ $niche->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger error" id="error-niche_id"></small>
                        </div>

                        <div class="form-group">
                            <label for="title">Project Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                            <small class="text-danger error" id="error-title"></small>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Enter description"></textarea>
                            <small class="text-danger error" id="error-description"></small>
                        </div>

                        <div class="form-group">
                            <label for="project_url">Project URL</label>
                            <input type="url" class="form-control" id="project_url" name="project_url"
                                placeholder="https://example.com">
                            <small class="text-danger error" id="error-project_url"></small>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary btn-block">
                            <span id="btnText">Create</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('adminScript')
    <script>
        $('#createProjectForm').on('submit', function (e) {
            e.preventDefault();

            $('.error').text('');
            $('#submitBtn').attr('disabled', true).addClass('disabled');
            $('#btnText').text('Creating...');

            $.ajax({
                url: '/api/projects/create',
                method: 'POST',
                data: {
                    niche_id: $('#niche_id').val(),
                    title: $('#title').val(),
                    description: $('#description').val(),
                    project_url: $('#project_url').val()
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Project created successfully.',
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        window.location.href = '{{ route('projects.index') }}';
                    });

                    $('#createProjectForm')[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#error-' + key).text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                            text: 'Please try again later.',
                            confirmButtonColor: '#d33',
                        });
                    }
                },
                complete: function () {
                    $('#submitBtn').attr('disabled', false).removeClass('disabled');
                    $('#btnText').text('Create');
                }
            });
        });
    </script>
@endsection