@extends('admin.layout')

@section('adminMain')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Update Niche</h5>
            </div>
            <div class="card-body">
                <form id="updateNicheForm">
                    <input type="hidden" id="niche_id" value="{{ $niche->id }}"> {{-- pass the ID here --}}

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $niche->name }}">
                        <small class="text-danger error" id="error-name"></small>
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $niche->slug }}">
                        <small class="text-danger error" id="error-slug"></small>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $niche->description }}</textarea>
                        <small class="text-danger error" id="error-description"></small>
                    </div>

                    <button type="submit" id="submitBtn" class="btn btn-info btn-block">
                        <span id="btnText">Update</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('adminScript')

<script>

    $('#updateNicheForm').on('submit', function (e) {
        e.preventDefault();

        $('.error').text('');
        $('#submitBtn').attr('disabled', true).addClass('disabled');
        $('#btnText').text('Updating...');

        const id = $('#niche_id').val();

        $.ajax({
            url: `/api/niches/update/${id}`,
            method: 'POST',
            data: {
                name: $('#name').val(),
                slug: $('#slug').val(),
                description: $('#description').val()
            },
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: 'Niche updated successfully.',
                    confirmButtonColor: '#3085d6',
                }).then(function(){
                    window.location.href = '{{route('niches.index')}}';
                });
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
                        title: 'Update failed!',
                        text: 'An error occurred. Please try again.',
                    });
                }
            },
            complete: function () {
                $('#submitBtn').attr('disabled', false).removeClass('disabled');
                $('#btnText').text('Update');
            }
        });
    });
</script>
@endsection
