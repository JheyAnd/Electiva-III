<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras Interactivo</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1, h2 {
            color: #2c3e50;
        }

        /* Estilos del carrito */
        .cart {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .cart-items {
            flex: 2;
            min-width: 300px;
        }
        .cart-summary {
            flex: 1;
            min-width: 250px;
        }

        /* Estilos de los productos */
        .product {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .product img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        .product-info {
            flex-grow: 1;
            margin-left: 20px;
        }
        .product-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-price {
            color: #e74c3c;
        }
        .product-quantity {
            display: flex;
            align-items: center;
        }
        .quantity-btn {
            background-color: #ecf0f1;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }
        .quantity-btn:hover {
            background-color: #bdc3c7;
        }
        .quantity {
            margin: 0 10px;
        }
        .remove-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .remove-btn:hover {
            background-color: #c0392b;
        }

        /* Estilos del resumen */
        .summary {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-total {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 1px solid #ecf0f1;
            padding-top: 10px;
        }
        .promo-code {
            display: flex;
            margin-top: 20px;
        }
        .promo-code input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 4px 0 0 4px;
        }
        .promo-code button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .promo-code button:hover {
            background-color: #2980b9;
        }
        .action-buttons {
            margin-top: 20px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #2ecc71;
            color: white;
        }
        .btn-primary:hover {
            background-color: #27ae60;
        }
        .btn-secondary {
            background-color: #ecf0f1;
            color: #2c3e50;
        }
        .btn-secondary:hover {
            background-color: #bdc3c7;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #2ecc71;
            stroke-miterlimit: 10;
            margin: 10% auto;
            box-shadow: inset 0px 0px 0px #2ecc71;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        }
        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #2ecc71;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }
        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }
        @keyframes scale {
            0%, 100% {
                transform: none;
            }
            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }
        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #2ecc71;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .cart {
                flex-direction: column;
            }
            .cart-items, .cart-summary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tu Carrito de Compras</h1>
        <div class="cart">
            <div class="cart-items">
                <div class="product" data-price="100000">
                    <img src="/placeholder.svg" alt="Perfume A">
                    <div class="product-info">
                        <div class="product-title">Perfume A</div>
                        <div class="product-price">COP 100,000</div>
                    </div>
                    <div class="product-quantity">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">1</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                    <button class="remove-btn">Eliminar</button>
                </div>
                <div class="product" data-price="150000">
                    <img src="/placeholder.svg" alt="Perfume B">
                    <div class="product-info">
                        <div class="product-title">Perfume B</div>
                        <div class="product-price">COP 150,000</div>
                    </div>
                    <div class="product-quantity">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">2</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                    <button class="remove-btn">Eliminar</button>
                </div>
                <div class="product" data-price="200000">
                    <img src="/placeholder.svg" alt="Perfume C">
                    <div class="product-info">
                        <div class="product-title">Perfume C</div>
                        <div class="product-price">COP 200,000</div>
                    </div>
                    <div class="product-quantity">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">1</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                    <button class="remove-btn">Eliminar</button>
                </div>
            </div>
            <div class="cart-summary">
                <div class="summary">
                    <h2>Resumen del Pedido</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">COP 600,000</span>
                    </div>
                    <div class="summary-row">
                        <span>Descuento del producto</span>
                        <span id="product-discount">COP 0</span>
                    </div>
                    <div class="summary-row">
                        <span>IVA (19%)</span>
                        <span id="iva">COP 114,000</span>
                    </div>
                    <div class="summary-row">
                        <span>Descuento promocional</span>
                        <span id="promo-discount">COP 0</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total a pagar</span>
                        <span id="total">COP 714,000</span>
                    </div>
                    <div class="promo-code">
                        <input type="text" id="promo-code-input" placeholder="Código promocional">
                        <button id="apply-promo">Aplicar</button>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-primary" id="pay-btn">Pagar</button>
                        <button class="btn btn-secondary">Seguir Comprando</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
            <h2>¡Pago Exitoso!</h2>
            <p>Tu pedido ha sido procesado correctamente.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = document.querySelector('.cart-items');
            const subtotalEl = document.getElementById('subtotal');
            const ivaEl = document.getElementById('iva');
            const totalEl = document.getElementById('total');
            const promoCodeInput = document.getElementById('promo-code-input');
            const applyPromoBtn = document.getElementById('apply-promo');
            const promoDiscountEl = document.getElementById('promo-discount');
            const payBtn = document.getElementById('pay-btn');
            const modal = document.getElementById('paymentModal');
            const closeBtn = document.querySelector('.close');

            function updateTotals() {
                let subtotal = 0;
                cart.querySelectorAll('.product').forEach(product => {
                    const price = parseInt(product.dataset.price);
                    const quantity = parseInt(product.querySelector('.quantity').textContent);
                    subtotal += price * quantity;
                });

                const iva = subtotal * 0.19;
                const total = subtotal + iva;

                subtotalEl.textContent = `COP ${subtotal.toLocaleString()}`;
                ivaEl.textContent = `COP ${iva.toLocaleString()}`;
                totalEl.textContent = `COP ${total.toLocaleString()}`;
            }

            cart.addEventListener('click', function(e) {
                if (e.target.classList.contains('quantity-btn')) {
                    const product = e.target.closest('.product');
                    const quantityEl = product.querySelector('.quantity');
                    let quantity = parseInt(quantityEl.textContent);

                    if (e.target.classList.contains('plus')) {
                        quantity++;
                    } else if  (e.target.classList.contains('minus')) {
                        quantity = Math.max(1, quantity - 1);
                    }

                    quantityEl.textContent = quantity;
                    updateTotals();
                } else if (e.target.classList.contains('remove-btn')) {
                    e.target.closest('.product').remove();
                    updateTotals();
                }
            });

            applyPromoBtn.addEventListener('click', function() {
                const promoCode = promoCodeInput.value.trim().toUpperCase();
                if (promoCode === 'DESCUENTO20') {
                    const subtotal = parseInt(subtotalEl.textContent.replace(/[^0-9]/g, ''));
                    const discount = subtotal * 0.2;
                    promoDiscountEl.textContent = `COP ${discount.toLocaleString()}`;
                    updateTotals();
                } else {
                    alert('Código promocional inválido');
                }
            });

            payBtn.addEventListener('click', function() {
                modal.style.display = 'block';
            });

            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });

            updateTotals();
        });
    </script>
</body>
</html>