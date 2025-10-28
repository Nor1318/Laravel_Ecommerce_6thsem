@extends('template')

@section('content')


<section class="products">
    <h2>Todays Top Pick</h2>
    <div class="product-list" id="product-list">
        <div class="product">
            <img src="https://via.placeholder.com/150" alt="Product 1">
            <h3>Product 1</h3>
            <p>Rs. 20.00</p>
        </div>
        <div class="product">
            <img src="https://via.placeholder.com/150" alt="Product 2">
            <h3>Product 2</h3>
            <p>Rs. 30.00</p>
        </div>
        <div class="product">
            <img src="https://via.placeholder.com/150" alt="Product 3">
            <h3>Product 3</h3>
            <p>Rs. 40.00</p>
        </div>
        <div class="product">
            <img src="https://via.placeholder.com/150" alt="Product 3">
            <h3>Product 4</h3>
            <p>Rs. 40.00</p>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('/products')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(products => {
                renderProducts(products.slice(0, 4));
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    });

    function renderProducts(products) {
        const productList = document.getElementById('product-list');
            productList.innerHTML = '';

            products.forEach(product => {
            const productLink = document.createElement('a');
            productLink.href = `/product/${product.id}`;
            productLink.classList.add('product-link');

            const productDiv = document.createElement('div');
            productDiv.classList.add('product');

            productDiv.innerHTML = `
                <img src="${product.photo_url}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p>Rs. ${parseFloat(product.cost).toFixed(2)}</p>
            `;

            productLink.appendChild(productDiv);

            productList.appendChild(productLink);
        });
    }
</script>
@endsection