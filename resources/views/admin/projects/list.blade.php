@extends('admin.layout')
@section('adminMain')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body ">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="card-title">Project List</h1>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{route('projects.create')}}" class="btn btn-primary mr-2">
                                Add Project
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
                                    <th>Name</th>
                                    <th>niche</th>
                                    <th>Description</th>
                                    <th>Project Url</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{$project->title }}</td>
                                        <td>{{$project->niche->name}}</td>
                                        <td>{{Str::limit($project->description, 25, '...')}}</td>
                                        <td>{{$project->project_url}}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-4">
                                                <a href="{{route('projects.show',$project->id)}}" class="btn">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{route('projects.edit', $project->id)}}" class="btn">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn delete_Btn" data-id="{{$project->id}}"
                                                    data-name="{{$project->name}}">
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
                            url: '/api/projects/delete/' + nicheId,
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