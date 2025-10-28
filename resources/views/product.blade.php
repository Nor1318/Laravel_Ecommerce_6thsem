
@extends('template')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ProductStyle.css') }}">
<div class="product-container">
    <div class="product-image">
        <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}">
    </div>
    <div class="product-details">
        <h1 class="product-title">{{$product->name}}</h1>
        <p class="product-description">{{$product->detail}}</p>
        <p class="product-price">Rs. {{$product->cost}}</p>
        <div class="product-actions">
            <form action="{{ route('addToCart') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="price" value="{{ $product->cost }}">
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                </div>
                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>
        <div class="additional-info">
            <p><strong>Category:</strong> {{$category->title}}</p>
            <p><strong>Stock:</strong> In Stock</p>
        </div>
    </div>
</div>
@endsection