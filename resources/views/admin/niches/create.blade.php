@extends('admin.layout')

@section('adminMain')
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h5 class="mb-0">Create New Niche</h5>
                </div>
                <div class="card-body">
                    <form id="createNicheForm">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                            <small class="text-danger error" id="error-name"></small>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug">
                            <small class="text-danger error" id="error-slug"></small>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Enter description"></textarea>
                            <small class="text-danger error" id="error-description"></small>
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
        $('#createNicheForm').on('submit', function (e) {
            e.preventDefault();
            // Clear previous errors
            $('.error').text('');
            $('#submitBtn').attr('disabled', true).addClass('disabled');
            $('#btnText').text('Creating...');

            $.ajax({
                url: '/api/niches/create',
                method: 'POST',
                data: {
                    name: $('#name').val(),
                    slug: $('#slug').val(),
                    description: $('#description').val()
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Niche created successfully.',
                        confirmButtonColor: '#3085d6',
                    }).then(function(){
                        window.location.href = '{{route('niches.index')}}';
                    });

                    $('#createNicheForm')[0].reset();
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