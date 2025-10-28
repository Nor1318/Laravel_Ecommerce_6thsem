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
                        <div class="col-md-10">Manage Product</div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ProductCreateModal">
                                Add
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Photo</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Cost</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($product as $item)
                        <tr>
                            <td><img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" style="height:100px; width:100px;"></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->detail}}</td>
                            <td>{{$item->cost}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ProductEditModal" data-id="{{$item->id}}">
                                    Edit
                                </button>
                                &nbsp
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ProductDeleteModal" data-id="{{$item->id}}">
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

<!-- Product Create Modal -->
<div class="modal fade" id="ProductCreateModal" tabindex="-1" aria-labelledby="ProductCModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProductCModal">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" action="{{ route('addProduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail</label>
                        <textarea class="form-control" id="detail" name="detail" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost</label>
                        <input type="number" step="0.01" class="form-control" id="cost" name="cost" required>
                    </div>

                    <div class="mb-3">
                        <label for="cat_id" class="form-label">Category ID</label>
                        <!-- <input type="number" class="form-control" id="cat_id" name="cat_id"> -->
                        <select id="categorySelect" class="form-select" name="cat_id" required>
                            <option value="">Select a Category</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Product Edit Modal -->
<div class="modal fade" id="ProductEditModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST" action="{{ route('updateProduct') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editProductId" name="id">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editProductName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductDetail" class="form-label">Detail</label>
                        <textarea class="form-control" id="editProductDetail" name="detail" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editProductCost" class="form-label">Cost</label>
                        <input type="number" class="form-control" id="editProductCost" name="cost" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductCatId" class="form-label">Category ID</label>
                        <!-- <input type="number" class="form-control" id="editProductCatId" name="cat_id" required> -->
                        <select id="editProductCatId" class="form-select" name="cat_id" required>
                            <option value="">Select a Category</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editProductPhoto" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="editProductPhoto" name="photo">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Product Delete Modal -->
<div class="modal fade" id="ProductDeleteModal" tabindex="-1" aria-labelledby="ProductDModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProductDModal">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="far fa-times-circle" style="font-size: 100px; color: red;"></i>
                <h4 class="mt-3">Are you sure you want to delete this product?</h4>
                <p class="text-muted">This action cannot be undone.</p>

                <form id="deleteProductForm" method="POST" action="" class="mt-4">
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
        const addButtons = document.querySelectorAll('[data-bs-target="#ProductCreateModal"]');
        const selectElement = document.getElementById('categorySelect');

        addButtons.forEach(button => {
            button.addEventListener('click', function () {
                fetch(`/manage/category/list`)
                    .then(response => response.json())
                    .then(data => {
                        selectElement.innerHTML = '<option value="">Select a Category</option>';
                        console.log(data);
                        data.forEach(category => {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.title;
                            selectElement.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching product data:', error));
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('[data-bs-target="#ProductEditModal"]');
        const categorySelect = document.getElementById('editProductCatId');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');

                fetch(`/manage/product/${productId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editProductId').value = data.id;
                        document.getElementById('editProductName').value = data.name;
                        document.getElementById('editProductDetail').value = data.detail;
                        document.getElementById('editProductCost').value = data.cost;

                        fetch(`/manage/category/list`)
                            .then(categoryResponse => categoryResponse.json())
                            .then(categories => {
                                categorySelect.innerHTML = '<option value="">Select a Category</option>';

                                categories.forEach(category => {
                                    const option = document.createElement('option');
                                    option.value = category.id;
                                    option.textContent = category.title;

                                    if (category.id === data.cat_id) {
                                        option.selected = true;
                                    }

                                    categorySelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error('Error fetching category data:', error));
                    })
                    .catch(error => console.error('Error fetching product data:', error));
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('[data-bs-target="#ProductDeleteModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const ProductId = this.getAttribute('data-id');
                const form = document.getElementById('deleteProductForm');
                form.action = `product/${ProductId}/delete`;
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