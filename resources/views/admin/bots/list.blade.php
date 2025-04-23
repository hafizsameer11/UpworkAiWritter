@extends('admin.layout')
@section('adminMain')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body ">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="card-title">Bot List</h1>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{route('bots.create')}}" class="btn btn-primary mr-2">
                                Add Bot
                            </a>
                            <form action="" class="d-flex align-items-center">
                                <input type="text" placeholder="Search niches" class="form-control mr-1">
                                <button class="btn btn-primary d-flex align-items-center" type="submit">
                                    {{-- icon --}}
                                    <i class="fas fa-search mr-2"></i>
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="child_rows" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>image</th>
                                    <th>Name</th>
                                    <th>System Promt</th>
                                    <th>Openai Model</th>
                                    <th>Fine Tuned Model Id</th>
                                    <th>niche</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bots as $bot)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $bot->image) }}" alt="{{$bot->name}}" style="width: 50px;height: 50px;">
                                        </td>
                                        <td>{{$bot->name}}</td>
                                        <td>{{ Str::limit($bot->system_prompt, 25, '...') }}</td>
                                        <td>{{$bot->openai_model}}</td>
                                        <td>{{($bot->fine_tuned_model_id) ? $bot->fine_tuned_model_id : 'N/A'}}</td>
                                        <td>{{$bot->niche->name}}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-4">
                                                <a href="{{route('bots.show', $bot->id)}}" class="btn">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{route('bots.edit', $bot->id)}}" class="btn">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn delete_Btn" data-id="{{$bot->id}}"
                                                    data-name="{{$bot->name}}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
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
                            url: '/api/bots/delete/' + nicheId,
                            method: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: `${nicheName} has been deleted.`
                                }).then(function () {
                                    location.reload();
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