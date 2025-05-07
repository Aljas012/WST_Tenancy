@extends('layouts.tenantPageLayout')
@section('content')
@section('title', 'Inventory')

@php
$colorMapping = [
'purple' => 'primary',
'green' => 'success',
'orange' => 'warning',
'danger' => 'danger',
'azure' => 'info',
];
$cardColor = $colorMapping[$settings->color ?? 'purple'] ?? 'primary';
@endphp


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="card">
                    <div class="card-header card-header-{{ $cardColor }} d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Inventory Table</h4>
                            <p class="card-category">List of all cars undergoing maintenance</p>
                        </div>
                        <button type="button" class="btn btn-{{ $cardColor }}" style="display: flex; align-items: center; gap: 8px;" id="openinventoryAdd">
                            <i class="material-icons">inventory_2</i>
                            Add Product
                        </button>
                    </div>

                    <div class="card-body table-responsive bodyWrapper scrollbar-{{ $cardColor }}">
                        @include('components.inventoryAdd')
                        @include('components.cart')

                        @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: "{{ session('success') }}",
                                showConfirmButton: true,
                                timer: 3000,
                                background: '#242830',
                                color: '#fff',

                            });
                        </script>
                        @endif

                        @if ($errors->any())
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: "{{ $errors->first() }}",
                                showConfirmButton: true,
                                timer: 3000,
                                background: '#242830',
                                color: '#fff',
                            });
                        </script>
                        @endif

                        <div id="productContainer">
                            <div class="row">

                                <div class="col">
                                    <select class="form-control" name="category" id="filterCategory" style="max-width: 12rem;">
                                        <option style="color:rgb(125, 125, 125); background-color:rgb(40, 50, 75);" selected disabled> Product Category</option>

                                        <option value="Batteries" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Batteries</option>
                                        <option value="Brakes" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Brakes</option>
                                        <option value="Clutch System" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Clutch System</option>
                                        <option value="Filters" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Filters</option>
                                        <option value="Lubricants" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Lubricants</option>
                                        <option value="Tires" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Tires</option>

                                    </select>

                                </div>

                            </div>

                            @foreach($inventory->chunk(5) as $chunk)
                            <div class="row">
                                @foreach($chunk as $item)
                                <div class="col">
                                    <div class="card productDiv"
                                        data-part-number="{{ $item->part_number }}"
                                        data-description="{{ $item->description }}"
                                        data-price="{{ $item->price }}"
                                        data-quantity="{{ $item->quantity }}"
                                        data-category="{{ $item->category }}"
                                        onclick="addToCart(this)">


                                        <div class="card-header" style="margin: 0; padding: .8rem 1.2rem; color: #eaeaff;">
                                            <p class="h5 m-0">{{ $item->category }}</p>
                                        </div>

                                        <div class="card-body" style="margin: 0; padding: 0 1.2rem 1rem;">
                                            <h4 class="card-title">{{ $item->part_number }}</h4>
                                            <p class="card-text m-0">{{ $item->description }}</p>
                                            <p class="card-text">₱ {{ number_format($item->price, 2) }}</p>
                                        </div>

                                        <div class="card-footer m-0" style="padding: 0 1.2rem .3rem; color: #eaeaff">
                                            <div style="display: flex; justify-content: space-between; width: 100%;">
                                                <div>
                                                    <p style="margin: 0;">Quantity: {{ $item->quantity }}</p>
                                                </div>
                                                <div>
                                                    <i class="material-icons" style="cursor: pointer;">add_shopping_cart</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @for($i = 0; $i < (5 - $chunk->count()); $i++)
                                    <div class="col"></div>
                                    @endfor
                            </div>
                            @endforeach

                        </div>

                    </div>

                    <div id="cFooter" class="card-footer" style="padding: .6rem .5rem 0">
                        <div style="display: flex; justify-content: flex-end; align-items: end; width: 100%;">
                            <i id="cartIcon" class="material-icons" style="cursor: pointer; color: #eaeaff">shopping_cart</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inventoryBtn = document.getElementById("openinventoryAdd");
        const inventoryCmpnt = document.getElementById("inventoryAdd");
        const productContainer = document.getElementById("productContainer");
        const cFooter = document.getElementById("cFooter");
        const cartBtn = document.getElementById("cartIcon");
        const cart = document.getElementById("cartShow");

        inventoryBtn?.addEventListener("click", function() {

            if (productContainer) {
                productContainer.style.display = "none";
            }

            if (inventoryCmpnt) {
                inventoryCmpnt.style.display = "block";
                inventoryCmpnt.scrollIntoView({
                    behavior: "smooth"
                });
            }

            if (cart) {
                cart.style.display = "none";
            }

            if (cFooter) {
                cFooter.style.display = "none";
            }
        });

        cartBtn?.addEventListener("click", function() {

            if (productContainer) {
                productContainer.style.display = "none";
            }

            if (cart) {
                cart.style.display = "block";
                cart.scrollIntoView({
                    behavior: "smooth"
                });
            }

            if (cFooter) {
                cFooter.style.display = "none";
            }
        });



        const clsBtn = document.querySelector('#closeinventoryAdd');
        if (clsBtn) {
            clsBtn.addEventListener('click', function() {

                if (inventoryCmpnt) {
                    inventoryCmpnt.style.display = "none";
                }

                if (productContainer) {
                    productContainer.style.display = "block";
                }

                if (cFooter) {
                    cFooter.style.display = "flex";
                }
            });
        }

        const clsCartBtn = document.querySelector('#clsCartBtn');
        if (clsCartBtn) {
            clsCartBtn.addEventListener('click', function() {

                if (cart) {
                    cart.style.display = "none";
                }

                if (productContainer) {
                    productContainer.style.display = "block";
                }

                if (cFooter) {
                    cFooter.style.display = "flex";
                }
            });
        }

    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryFilter = document.getElementById("filterCategory");
        const productDivs = document.querySelectorAll(".productDiv");

        categoryFilter.addEventListener("change", function() {
            const selectedCategory = categoryFilter.value.toLowerCase();

            productDivs.forEach(function(productDiv) {
                const productCategory = productDiv.getAttribute("data-category").toLowerCase(); // Get product category

                if (selectedCategory === "" || productCategory === selectedCategory) {
                    productDiv.style.display = "block";
                } else {
                    productDiv.style.display = "none";
                }
            });
        });
    });
</script>

<script>
    function addToCart(card) {
        // Extract product details from data attributes
        const partNumber = card.getAttribute('data-part-number');
        const description = card.getAttribute('data-description');
        const price = parseFloat(card.getAttribute('data-price'));
        const quantity = parseInt(card.getAttribute('data-quantity'));
        const category = card.getAttribute('data-category');

        // Find the cart table body
        const cartTableBody = document.querySelector('#cartShow tbody');

        // Check if the product already exists in the cart
        let productExists = false;
        cartTableBody.querySelectorAll('tr').forEach(row => {
            const productId = row.querySelector('.product-id').textContent;
            if (productId === partNumber) {
                productExists = true;
            }
        });

        if (!productExists) {
            // Add the product to the cart if not already added
            const row = document.createElement('tr');

            row.innerHTML = `
           <td>
                <input type="number" class="form-control quantity-input" value="1" min="1" max="${quantity}" 
                     onkeydown="restrictKeyboardInput(event)" inputmode="numeric" onchange="updateQuantity(this, '${partNumber}', ${price})">
            </td>
            <td class="product-id">${partNumber}</td>
            <td>${description}</td>
            <td>₱ ${price.toFixed(2)}</td>
            <td class="total-price">₱ ${price.toFixed(2)}</td>
        `;

            cartTableBody.appendChild(row);

            // Automatically calculate the total for the first entry
            updateQuantity(row.querySelector('.quantity-input'), partNumber, price);
        } else {
            Swal.fire({
                icon: 'error',
                title: `${partNumber} Already in the Cart`,
                showConfirmButton: true,
                timer: 3000,
                background: '#242830',
                color: '#fff',
            });
        }
    }

    function updateQuantity(input, partNumber, price) {
        const row = input.closest('tr');
        const quantity = parseInt(input.value);

        // Calculate total price
        const totalPrice = price * quantity;

        // Update the "Total" column
        row.querySelector('.total-price').textContent = '₱ ' + totalPrice.toFixed(2);
    }

    function restrictKeyboardInput(event) {
        // Block any key input
        event.preventDefault();
    }
</script>

<script>
    document.getElementById('chckOutBtn').addEventListener('click', function(event) {
        event.preventDefault(); // prevent normal submit

        const form = document.getElementById('checkoutForm');

        // Clear previous hidden inputs
        document.querySelectorAll('.dynamic-field').forEach(e => e.remove());

        const rows = document.querySelectorAll('tbody tr');

        rows.forEach((row, index) => {
            const quantity = row.querySelector('.quantity-input').value;
            const partNumber = row.querySelector('.product-id').textContent.trim();
            const total = row.querySelector('.total-price').textContent.replace('₱', '').replace(',', '').trim();

            // Create hidden inputs for each product
            form.insertAdjacentHTML('beforeend', `
            <input type="hidden" name="orders[${index}][part_number]" value="${partNumber}" class="dynamic-field">
            <input type="hidden" name="orders[${index}][quantity]" value="${quantity}" class="dynamic-field">
            <input type="hidden" name="orders[${index}][total]" value="${total}" class="dynamic-field">
        `);
        });

        form.submit(); // finally submit form
    });
</script>




@endsection