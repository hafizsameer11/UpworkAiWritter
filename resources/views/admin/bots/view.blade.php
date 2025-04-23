@extends('admin.layout')

@section('adminMain')
  <div class="row justify-content-center mt-4">
    <div class="col-md-8">
    <div class="card shadow-sm rounded-3 overflow-hidden">
      <div class="p-1 px-3 bg-primary text-white">
      <h1 class="card-title mb-0">{{ $bot->name }}</h1>
      </div>
      <div class="card-body">
      @if ($bot->image)
      <div class="mt-3">
      <strong>Image:</strong><br>
      <img src="{{ asset('storage/' . $bot->image) }}" class="img-thumbnail mt-2" style="max-height: 180px;">
      </div>
    @endif
      <p><strong>Niche ID:</strong> {{ $bot->niche->name }}</p>
      <p><strong>System Prompt:</strong><br> {{ $bot->system_prompt }}</p>
      <p><strong>OpenAI Model:</strong> {{ $bot->openai_model }}</p>
      </div>
      <div class="card-footer py-4">
      <div class="d-flex align-items-center gap-4">
        <a href="{{ route('bots.edit', $bot->id) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Edit
        </a>
        <button class="btn delete_Btn btn-danger ml-2" data-id="{{ $bot->id }}" data-name="{{ $bot->name }}">
        <i class="fas fa-trash"></i> Delete
        </button>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection
@section('adminScript')

  <script>
    $(document).ready(function () {
    $('.delete_Btn').on('click', function () {
      const botId = $(this).data('id');
      const botName = $(this).data('name');

      Swal.fire({
      title: 'Are you sure?',
      text: `You won't be able to revert this!`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: `Yes, delete ${botName}!`,
      preConfirm: () => new Promise((resolve) => resolve())
      }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
        url: '/api/bots/delete/' + botId,
        method: 'DELETE',
        success: function (response) {
          Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: `${botName} has been deleted.`
          }).then(() => {
          window.location.href = '{{ route('bots.index') }}';
          });
        },
        error: function (xhr) {
          Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'There was a problem deleting the bot. Please try again.'
          });
          console.error(xhr.responseText);
        }
        });
      }
      });
    });
    });
  </script>
@endsection