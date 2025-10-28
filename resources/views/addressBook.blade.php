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
                        <div class="col-md-10">Address Book</div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddressCreateModal">
                                Add
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($addresses->isEmpty())
                        <p>Your Address Book is empty.</p>
                    @else
                        <div class="container">
                            @foreach ($addresses as $item)
                            <div class="card mb-3 shadow">
                                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text mb-1"><strong>Phone:</strong> {{ $item->phone }}</p>
                                        <p class="card-text mb-1"><strong>Address:</strong> {{ $item->address_line1 }}, {{ $item->address_line2 }}</p>
                                        <p class="card-text mb-1"><strong>City:</strong> {{ $item->city }} | <strong>State:</strong> {{ $item->state }} | <strong>Country:</strong> {{ $item->country }}</p>
                                        <p class="card-text mb-1"><strong>Postal Code:</strong> {{ $item->postal_code }}</p>
                                        <p class="card-text"><strong>Default:</strong> {{ $item->is_default ? 'Yes' : 'No' }}</p>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#AddressEditModal" data-id="{{ $item->id }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#AddressDeleteModal" data-id="{{ $item->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Address Create Modal -->
<div class="modal fade" id="AddressCreateModal" tabindex="-1" aria-labelledby="AddressCModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddressCModal">Add Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAddressForm" action="{{ route('addAddress') }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="address_line1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="address_line1" name="address_line1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address_line2" class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" id="address_line2" name="address_line2">
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" id="state" name="state" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="is_default" class="form-label">Set as Default</label>
                        <input type="checkbox" class="form-check-input" id="is_default" name="is_default">
                    </div>

                    <button type="submit" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Address Edit Modal -->
<div class="modal fade" id="AddressEditModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAddressForm" action="{{ route('updateAddress') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editAddressId" name="id">
                    
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_address_line1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="edit_address_line1" name="address_line1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_address_line2" class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" id="edit_address_line2" name="address_line2">
                    </div>

                    <div class="mb-3">
                        <label for="edit_city" class="form-label">City</label>
                        <input type="text" class="form-control" id="edit_city" name="city" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_state" class="form-label">State</label>
                        <input type="text" class="form-control" id="edit_state" name="state" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="edit_country" name="country" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_postal_code" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="edit_postal_code" name="postal_code" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_default" name="is_default">
                        <label class="form-check-label" for="edit_is_default">Set as Default</label>
                    </div>

                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Address Delete Modal -->
<div class="modal fade" id="AddressDeleteModal" tabindex="-1" aria-labelledby="AddressDModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddressDModal">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="far fa-times-circle" style="font-size: 100px; color: red;"></i>
                <h4 class="mt-3">Are you sure you want to delete this address?</h4>
                <p class="text-muted">This action cannot be undone.</p>

                <form id="deleteAddressForm" method="POST" action="" class="mt-4">
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
    document.addEventListener('DOMContentLoaded', function () {
        const responseModal = new bootstrap.Modal(document.getElementById('responseModal'));

        if (document.getElementById('responseModal')) {
            responseModal.show();

            setTimeout(function () {
                responseModal.hide();
            }, 1250);
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const editButtons = document.querySelectorAll("[data-bs-target='#AddressEditModal']");

        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                const addressId = this.getAttribute("data-id");

                fetch(`addressBook/${addressId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("editAddressId").value = data.id;
                        document.getElementById("edit_name").value = data.name;
                        document.getElementById("edit_phone").value = data.phone;
                        document.getElementById("edit_address_line1").value = data.address_line1;
                        document.getElementById("edit_address_line2").value = data.address_line2 || "";
                        document.getElementById("edit_city").value = data.city;
                        document.getElementById("edit_state").value = data.state;
                        document.getElementById("edit_country").value = data.country;
                        document.getElementById("edit_postal_code").value = data.postal_code;
                        
                        document.getElementById("edit_is_default").checked = data.is_default == 1;
                    })
                    .catch(error => console.error("Error fetching address data:", error));
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('[data-bs-target="#AddressDeleteModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const AddressId = this.getAttribute('data-id');
                const form = document.getElementById('deleteAddressForm');
                form.action = `addressBook/${AddressId}/delete`;
            });
        });
    });
</script>

@endsection