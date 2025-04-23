@extends('admin.layout')

@section('adminMain')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h5 class="mb-0">Create New Bot</h5>
                </div>
                <div class="card-body">
                    <form id="createBotForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Bot Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            <small class="text-danger error" id="error-image"></small>
                            <img id="preview" src="#" alt="Preview" class="img-thumbnail mt-2 d-none"
                                style="max-height: 150px;">
                        </div>
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
                            <label for="name">Bot Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter bot name">
                            <small class="text-danger error" id="error-name"></small>
                        </div>

                        <div class="form-group">
                            <label for="system_prompt">System Prompt</label>
                            <textarea class="form-control" id="system_prompt" name="system_prompt" rows="3"
                                placeholder="Enter system prompt"></textarea>
                            <small class="text-danger error" id="error-system_prompt"></small>
                        </div>

                        <div class="form-group">
                            <label for="openai_model">OpenAI Model</label>
                            <input type="text" class="form-control" id="openai_model" name="openai_model"
                                placeholder="e.g., gpt-4, gpt-3.5-turbo">
                            <small class="text-danger error" id="error-openai_model"></small>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary btn-block">
                            <span id="btnText">Create Bot</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('adminScript')
    <script>
        $('#image').on('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#preview').attr('src', event.target.result).removeClass('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        $('#createBotForm').on('submit', function (e) {
            e.preventDefault();

            $('.error').text('');
            $('#submitBtn').attr('disabled', true).addClass('disabled');
            $('#btnText').text('Creating...');

            let formData = new FormData(this);

            $.ajax({
                url: '/api/bots/create',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bot Created!',
                        text: res.message,
                    }).then(function(){
                        window.location.href = '{{route('bots.index')}}';
                    });
                    $('#createBotForm')[0].reset();
                    $('#preview').attr('src', '#').addClass('d-none');
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#error-' + key).text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                },
                complete: function () {
                    $('#submitBtn').attr('disabled', false).removeClass('disabled');
                    $('#btnText').text('Create Bot');
                }
            });
        });
    </script>
@endsection