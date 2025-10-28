@extends('template')

@section('content')
<link rel="stylesheet" href="{{ asset('css/CartStyle.css') }}">

<div class="cart-container">
    <h1>Your Shopping Cart</h1>

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

    @if ($cartItems->isEmpty())
    <div class="empty-cart">
        <p>Your cart is empty.</p>
        <a href="{{ route('allProducts') }}" class="cta-button">Shop Now</a>
    </div>

    @else
        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $item->product->photo) }}" alt="{{ $item->product->name }}" class="product-image">
                        </td>
                        <td>{{ $item->product->name }}</td>
                        <td>Rs. {{ number_format($item->price, 2) }}</td>
                        <td>{{$item->quantity}}</td>
                        <td>Rs.  {{ number_format($item->total_price, 2) }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UpdateCartItemModal" data-id="{{$item->id}}">
                                Update
                            </button>
                            &nbsp
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeleteCartItemModal" data-id="{{$item->id}}">
                                Delete
                            </button>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <p><strong>Total Price:</strong> Rs. {{ number_format($totalPrice, 2) }}</p>
            <a href="{{ route('CheckOut') }}" class="checkout-btn">Proceed to Checkout</a>
        </div>
    @endif
</div>

<!-- Cart Item update Modal -->
<div class="modal fade" id="UpdateCartItemModal" tabindex="-1" aria-labelledby="UpdateCartItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateCartItemModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="updateCartItemForm" action="{{ route('addToCart') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id">

                <div class="mb-3">
                    <label class="form-label">Product Name:</label>
                    <p class="form-control-plaintext" id="product_name"></p>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="text" name="price" id="price" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Update Cart</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</div>

<!-- Cart Item Delete Modal -->
<div class="modal fade" id="DeleteCartItemModal" tabindex="-1" aria-labelledby="CartItemDModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CartItemDModal">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="far fa-times-circle" style="font-size: 100px; color: red;"></i>
                <h4 class="mt-3">Are you sure you want to delete this product from your cart?</h4>
                <p class="text-muted">This action cannot be undone.</p>

                <form id="deleteCartItemForm" method="POST" action="" class="mt-4">
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

    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('[data-bs-target="#UpdateCartItemModal"]'); // Edit buttons

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                fetch(`/cart/${productId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("1");
                        // Update modal fields with product data
                        document.querySelector('#updateCartItemForm input[name="product_id"]').value = data.product_id;
                        document.querySelector('#product_name').textContent = data.name;
                        document.querySelector('#updateCartItemForm input[name="price"]').value = data.price;
                        document.querySelector('#updateCartItemForm input[name="quantity"]').value = data.quantity; // ✅ Set existing quantity
                    })
                    .catch(error => console.error('Error fetching product data:', error));
            });
        });
    });

    
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('[data-bs-target="#DeleteCartItemModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const CartId = this.getAttribute('data-id');
                const form = document.getElementById('deleteCartItemForm');
                form.action = `cart/${CartId}/delete`;
            });
        });
    });
</script>
@endsection