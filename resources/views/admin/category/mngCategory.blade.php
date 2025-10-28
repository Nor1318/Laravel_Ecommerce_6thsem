@extends('template')

@section('content')
<div class="container">
        @if (session('success'))
            <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="border:4px solid green;">
                        <div class="modal-header justify-content-center">
                            <h5 class="modal-title" id="responseModalLabel" style="color:green;">Success</h5>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body text-center">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">Manage Category</div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#CategoryCreateModal">
                                Add
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Category Title</th>
                            <th>Description</th>
                            <th>Create date</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($categories as $item)
                        <tr>
                            <td>{{$item->title}}</td>
                            <td>{{$item->details}}</td>
                            <td>{{$item->updated_at}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CategoryEditModal" data-id="{{$item->id}}">
                                    Edit
                                </button>
                                &nbsp
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#CategoryDeleteModal" data-id="{{$item->id}}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Category Create Modal -->
<div class="modal fade" id="CategoryCreateModal" tabindex="-1" aria-labelledby="CategoryCModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CategoryCModal">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="{{ route('addCategory') }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">Details</label>
                        <textarea class="form-control" id="details" name="details" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Category Edit Modal -->
<div class="modal fade" id="CategoryEditModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" action="{{ route('updateCategory') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editCategoryId" name="id">
                    <div class="mb-3">
                        <label for="editCategoryTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editCategoryTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategoryDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="editCategoryDetails" name="details" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Category Delete Modal -->
<div class="modal fade" id="CategoryDeleteModal" tabindex="-1" aria-labelledby="CategoryDModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CategoryDModal">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="far fa-times-circle" style="font-size: 100px; color: red;"></i>
                <h4 class="mt-3">Are you sure you want to delete this category?</h4>
                <p class="text-muted">This action cannot be undone.</p>

                <form id="deleteCategoryForm" method="POST" action="" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('[data-bs-target="#CategoryEditModal"]');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const categoryId = this.getAttribute('data-id');

                fetch(`/manage/category/${categoryId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editCategoryId').value = data.id;
                        document.getElementById('editCategoryTitle').value = data.title;
                        document.getElementById('editCategoryDetails').value = data.details;
                    })
                    .catch(error => console.error('Error fetching category data:', error));
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('[data-bs-target="#CategoryDeleteModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const CategoryId = this.getAttribute('data-id');
                const form = document.getElementById('deleteCategoryForm');
                form.action = `category/${CategoryId}/delete`;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const responseModal = new bootstrap.Modal(document.getElementById('responseModal'));

        if (document.getElementById('responseModal')) {
            responseModal.show();

            setTimeout(function () {
                responseModal.hide();
            }, 1250);
        }
    });
</script>

@endsection