@extends('template')

@section('content')
<link rel="stylesheet" href="{{ asset('css/CartStyle.css') }}">
<link rel="stylesheet" href="{{ asset('css/CheckOutStyle.css') }}">

<div class="row cart-container">
    <!-- Cart Items Section -->
    <div class="col-md-8">
        <div class="container cart-items">
            <h1 class="cart-title">Your Shopping Cart</h1>

            <!-- Success Message Modal -->
            @if (session('success'))
                <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border: 4px solid green;">
                            <div class="modal-header justify-content-center">
                                <h5 class="modal-title" id="responseModalLabel" style="color: green;">Success</h5>
                            </div>
                            <div class="modal-body text-center">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Empty Cart Message -->
            @if ($cartItems->isEmpty())
                <div class="empty-cart">
                    <p>Your cart is empty.</p>
                    <a href="{{ route('allProducts') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @else
                <!-- Cart Table -->
                <div class="cart-table-wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $item->product->photo) }}" alt="{{ $item->product->name }}" class="product-image">
                                    </td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rs. {{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cart Summary -->
                <div class="cart-summary">
                    <p><strong>Total Price:</strong> Rs. {{ number_format($totalPrice, 2) }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Address and Payment Section -->
    <div class="col-md-4">
        <!-- Address Section -->
        <div class="container address-section">
            <h1 class="section-title">Your Address</h1>
            @if($address)
                <div class="address-details">
                    <div class="address-item">
                        <strong>Name:</strong> {{ $address->name }}
                    </div>
                    <div class="address-item">
                        <strong>Phone:</strong> {{ $address->phone }}
                    </div>
                    <div class="address-item">
                        <strong>Address Line 1:</strong> {{ $address->address_line1 }}
                    </div>
                    <div class="address-item">
                        <strong>Address Line 2:</strong> {{ $address->address_line2 }}
                    </div>
                    <div class="address-item">
                        <strong>City, State, Country:</strong> {{ $address->city }}, {{ $address->state }}, {{ $address->country }}
                    </div>
                </div>
            @else
                <p>No address found. Please add an address.</p>
            @endif
            <button class="btn btn-primary btn-manage-address" onclick="window.location.href='{{ route('getAddresses') }}'">
                Manage Addresses
            </button>
        </div>

        <!-- Payment Options Section -->
        <div class="container payment-options">
            <h1 class="section-title">Payment Options</h1>
            <div>
            <div class="payment-btns">
                <a class="btn btn-pay-esewa" href="{{ route('esewa.pay') }}">
                    <i class="fab fa-cc-paypal"></i> Esewa
                </a>
                <button class="btn btn-pay-cash">
                    <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                </button>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Cart Page -->
<style>
    .cart-container {
        padding: 30px;
        margin-top: 20px;
    }

    .cart-title, .section-title {
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .cart-table-wrapper {
        overflow-x: auto;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .cart-table th, .cart-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .cart-table th {
        background-color: #f1f1f1;
        font-weight: bold;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }

    .cart-summary {
        text-align: right;
        font-size: 18px;
        margin-top: 20px;
        font-weight: bold;
        color: #333;
    }

    .empty-cart {
        text-align: center;
        padding: 40px;
    }

    .empty-cart p {
        font-size: 20px;
        margin-bottom: 20px;
    }

    .address-section, .payment-options {
        background-color: #f8f9fa;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .address-item {
        margin-bottom: 10px;
        font-size: 16px;
        color: #555;
    }

    .btn-manage-address {
        width: 100%;
        margin-top: 15px;
        font-size: 16px;
    }

    .payment-btns {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-pay-esewa, .btn-pay-cash {
        width: 100%;
        padding: 12px;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .btn-pay-esewa {
        background-color: #28a745;
        color: white;
    }

    .btn-pay-esewa:hover {
        background-color: #218838;
    }

    .btn-pay-cash {
        background-color: #007bff;
        color: white;
    }

    .btn-pay-cash:hover {
        background-color: #0056b3;
    }
</style>

<!-- Script to Show Success Modal -->
@if (session('success'))
<script>
    $(document).ready(function() {
        $('#responseModal').modal('show');
    });
</script>
@endif

@endsection
