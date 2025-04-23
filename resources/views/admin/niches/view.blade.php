@extends('admin.layout')
@section('adminMain')
   <div class="row justify-content-center mt-4">
      <div class="col-md-6">
        <div class="card shadow-sm rounded-3 overflow-hidden">
          <div class="p-1 px-3 bg-primary">
            <h1 class="card-title">{{$niche->name}}</h1>
          </div>
          <div class="card-body">
            <h6><strong>Slug : </strong> {{ $niche->slug }}</h6>
            <p>{{ $niche->description }}</p>
          </div>
          <div class="card-footer py-4">
            <div class="d-flex align-items-center gap-4">
               <a href="{{route('niches.edit', $niche->id)}}" class="btn btn-primary">
                 <i class="fas fa-edit"></i> Edit
               </a>
               <button class="btn delete_Btn btn-danger ml-2" data-id="{{$niche->id}}" data-name="{{$niche->name}}">
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
          const nicheId = $(this).data('id');
          const nicheName = $(this).data('name')

          // confirm using sweetalert
          Swal.fire({
            title: 'Are you sure?',
            text: 'You won’t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: `Yes, delete ${nicheName}!`,
            preConfirm: () => { return new Promise((resolve) => { resolve(); }); }
          }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                 url: '/api/niches/delete/' + nicheId,
                 method: 'DELETE',
                 success: function (response) {
                   Swal.fire({
                     icon: 'success',
                     title: 'Deleted!',
                     text: `${nicheName} has been deleted.`
                   }).then(function () {
                     window.location.href = '{{route('niches.index')}}';
                   });
                 },
                 error: function (xhr) {
                   Swal.fire({ icon: 'error', title: 'Error!', text: 'There was a problem deleting the niche. Please try again.' });
                   console.error(xhr.responseText);
                 }
               });
            }
          });


        })

      });
   </script>
@endsection