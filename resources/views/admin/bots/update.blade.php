@extends('admin.layout')

@section('adminMain')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h5 class="mb-0">Update Bot</h5>
                </div>
                <div class="card-body">
                    <form id="updateBotForm" enctype="multipart/form-data">
                        <input type="hidden" id="bot_id" value="{{ $bot->id }}">
                        <div class="form-group">
                            <label for="image">Update Bot Image</label>
                            <img id="preview" src="{{ asset('storage/' . $bot->image) }}"
                                class="img-thumbnail  mt-2 {{ $bot->image ? 'd-block' : 'd-none' }}" style="max-height: 150px;">
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            <small class="text-danger error" id="error-image"></small>

                        </div>
                        <div class="form-group">
                            <label for="niche_id">Niche ID</label>
                            <select name="niche_id" id="niche_id" class="form-control">
                                <option value="">Select Niche</option>
                                @foreach ($niches as $niche)
                                    <option value="{{$niche->id}}" {{ $bot->niche_id == $niche->id ? 'selected' : '' }}>
                                        {{ $niche->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger error" id="error-niche_id"></small>
                        </div>

                        <div class="form-group">
                            <label for="name">Bot Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $bot->name }}">
                            <small class="text-danger error" id="error-name"></small>
                        </div>

                        <div class="form-group">
                            <label for="system_prompt">System Prompt</label>
                            <textarea class="form-control" id="system_prompt" name="system_prompt"
                                rows="3">{{ $bot->system_prompt }}</textarea>
                            <small class="text-danger error" id="error-system_prompt"></small>
                        </div>

                        <div class="form-group">
                            <label for="openai_model">OpenAI Model</label>
                            <input type="text" class="form-control" id="openai_model" name="openai_model"
                                value="{{ $bot->openai_model }}">
                            <small class="text-danger error" id="error-openai_model"></small>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary btn-block">
                            <span id="btnText">Update Bot</span>
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

        $('#updateBotForm').on('submit', function (e) {
            e.preventDefault();

            $('.error').text('');
            $('#submitBtn').attr('disabled', true).addClass('disabled');
            $('#btnText').text('Updating...');

            const formData = new FormData(this);
            const botId = $('#bot_id').val();

            $.ajax({
                url: `/api/bots/update/${botId}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: res.message,
                    }).then(function () {
                        window.location.href = '{{route(name: 'bots.index')}}';
                    });
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
                            text: 'Something went wrong!',
                        });
                    }
                },
                complete: function () {
                    $('#submitBtn').attr('disabled', false).removeClass('disabled');
                    $('#btnText').text('Update Bot');
                }
            });
        });
    </script>
@endsection