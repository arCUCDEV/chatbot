<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access tech - eCommerce</title>
    <!-- Style Css Link -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Style Css Link -->
    <!-- Font Awesome Cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Font Awesome Cdn -->
</head>
<body>
    <!-- Header Start -->
    <div class="header">
        <nav>
            <input type="checkbox" id="show-search">
            <input type="checkbox" id="show-menu">
            <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
            <div class="content">
    <div class="logo"><a href="index.html"><img src="/images/logo.png" alt=""></a></div>
    <ul class="links">
        <li><a href="#" id="first">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#product">Products</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#review">Reviews</a></li>
        <li><i class="fa fa-shopping-cart"><span id="cart-count">0</span></i></li>

        <!-- Usuarios autenticados -->
        <div class="auth">
            @auth
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
            
            <!-- Usuarios no autenticados -->
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endguest
        </div>
    </ul>
</div>

            <label for="show-search" class="search-icon"><i class="fas fa-search"></i></label>
            <form action="#" class="search-box">
                <input type="text" placeholder="Search" required>
                <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
            </form>
        </nav>
    </div>
    <!-- Header End -->
    <!-- Home Section Start -->
    <div class="home">
        <div id="cart-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Carrito de Compras</h2>
                <table id="cart-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cart-content"></tbody>
                </table>
                <div id="total">Total: $<span id="total-price">0</span></div>
            </div>
        </div>
        
        <div class="main-text">
            <h1>Discover The Best <br>Furniture For You</h1>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa inventore nulla quis doloribus modi magni iusto earum! Necessitatibus, quidem quia.</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa inventore nulla quis doloribus modi magni iusto earum! Necessitatibus, quidem quia.</p>
            <button id="btn">View More</button>
        </div>
    </div>
    <!-- Home Section End -->
    <!-- Top Section Card Start -->
    <section class="offers">
        <div class="offer-content">
            <div class="row">
                <i class="fa-solid fa-headset"></i>
                <h3>Support 24/7</h3>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="row">
                <i class="fa-solid fa-rotate-left"></i>
                <h3>30 Day Return</h3>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="row">
                <i class="fa-solid fa-cart-shopping"></i>
                <h3>Secure Shopping</h3>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
        </div>
    </section>
    <!-- Top Section Card End -->


    <!-- About Section Start -->
    <section class="about" id="about">
        <div class="about-img">
        </div>
        <div class="about-text">
            <h3>eCommerce service About us</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque nemo maxime, eligendi nesciunt quis quaerat cupiditate rerum enim obcaecati eum totam facilis, sunt tempore libero officia. Ad, excepturi. Qui, voluptatem officia aspernatur iure nam, architecto quos molestiae assumenda nesciunt porro voluptatum dolorum consequatur odit. Laudantium saepe sunt perspiciatis dolores ex.</p>
            <button id="about-btn">Read More...</button>
        </div>
        
    </section>
    <!-- About Section End -->
    <!-- Product Section Start -->
    <section class="product" id="product">
        <div class="main-txt">
            <h3>Products</h3>
        </div>
        <div class="card-content">
            <div class="row">
                <div class="flex-wrap">
                        @foreach ($products as $product)
                        <div class="product-item">
                            <img src="{{ $product->img_url }}" alt="">
                            <div class="card-body">
                                <h3>{{ $product->description }}</h3>
                                <p>{{ $product->marca }}</p>
                                <h5>Price ${{ $product->precio }}</h5>
                                <button class="order-button" data-product-id="{{ $product->id_products }}" data-product-name="{{ $product->description }}" data-product-price="{{ $product->precio }}" data-product-img="{{ $product->img_url }}">Order now</button>
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->


   
<script>
var botmanWidget = {
    frameEndpoint: '/botman/chat',
    title: "Access tech - Virtual assist",
    bubbleBackground: "#3498DB",
    mainColor: "#3498DB",
    titleColor: "#fff"
};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
<script>

    var cart = [];
    var total = 0;

    window.onload = function() {
    var buttons = document.getElementsByClassName('order-button');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', function(e) {
            var productId = e.target.getAttribute('data-product-id');

            axios.post('/cart/add', {
                productId: productId
            })
            .then(function (response) {
                cart.push(response.data.product);
                document.getElementById('cart-count').innerText = cart.length;
            })
            .catch(function (error) {
                console.log(error);
            });
        });
    }

    var cartIcon = document.getElementsByClassName('fa-shopping-cart')[0];
    cartIcon.addEventListener('click', function() {
        axios.get('/cart')
        .then(function(response) {
            var cartContent = document.getElementById('cart-content');
            cartContent.innerHTML = ''; // Limpiamos el contenido del carrito
            total = 0;
            for (var i = 0; i < response.data.cart.length; i++) {
                var product = response.data.cart[i];
                var subtotal = product.price * product.quantity;
                total += subtotal;
                cartContent.innerHTML += '<tr><td><img src="' + product.img + '"/></td><td>' + product.name + '</td><td>$' + product.price + '</td><td><input type="number" min="1" value="' + product.quantity + '" data-product-id="' + product.id + '" class="quantity-input"></td><td>$' + subtotal + '</td><td><button class="remove-button" data-product-id="' + product.id + '">Eliminar</button></td></tr>';
            }
            document.getElementById('total-price').innerText = total;
            document.getElementById('cart-modal').style.display = 'block'; // Mostramos el modal del carrito

            // Event handlers para los botones de eliminar y actualizar cantidad
            var removeButtons = document.getElementsByClassName('remove-button');
            for (var i = 0; i < removeButtons.length; i++) {
                removeButtons[i].addEventListener('click', function(e) {
                    var productId = e.target.getAttribute('data-product-id');
                    axios.post('/cart/remove', {
                        productId: productId
                    })
                    .then(function(response) {
                        e.target.parentElement.parentElement.remove();
                        document.getElementById('cart-count').innerText = response.data.cart.length;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                });
            }

            var quantityInputs = document.getElementsByClassName('quantity-input');
            for (var i = 0; i < quantityInputs.length; i++) {
                quantityInputs[i].addEventListener('change', function(e) {
                    var productId = e.target.getAttribute('data-product-id');
                    var newQuantity = e.target.value;
                    axios.post('/cart/update', {
                        productId: productId,
                        quantity: newQuantity
                    })
                    .then(function(response) {
                        // Actualizar el total
                        total = 0;
                        for (var i = 0; i < response.data.cart.length; i++) {
                            var product = response.data.cart[i];
                            var subtotal = product.price * product.quantity;
                            total += subtotal;
                        }
                        document.getElementById('total-price').innerText = total;
                    })
                    .catch(function (error) {
                console.log(error);
            });
        });
    }

    var cartIcon = document.getElementsByClassName('fa-shopping-cart')[0];
    cartIcon.addEventListener('click', function() {
        axios.get('/cart')
        .then(function(response) {
            // Renderiza el carrito basado en la respuesta del servidor
        })
        .catch(function(error) {
            console.log(error);
        });
    });

    var closeModal = document.getElementsByClassName('close-modal')[0];
    closeModal.addEventListener('click', function() {
        document.getElementById('cart-modal').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        var modal = document.getElementById('cart-modal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
};
</script>
<script>
    var cart = [];
    var total = 0;

    window.onload = function() {
        var buttons = document.getElementsByClassName('order-button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener('click', function(e) {
                var productId = e.target.getAttribute('data-product-id');
                var productName = e.target.getAttribute('data-product-name');
                var productPrice = e.target.getAttribute('data-product-price');
                var productImg = e.target.getAttribute('data-product-img');
                var product = {id: productId, name: productName, price: productPrice, img: productImg, quantity: 1};
                var found = false;
                for (var i = 0; i < cart.length; i++) {
                    if (cart[i].id === product.id) {
                        cart[i].quantity++;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    cart.push(product);
                }
                document.getElementById('cart-count').innerText = cart.length;
            });
        }

        var cartIcon = document.getElementsByClassName('fa-shopping-cart')[0];
        cartIcon.addEventListener('click', function() {
            var cartContent = document.getElementById('cart-content');
            cartContent.innerHTML = ''; // Limpiamos el contenido del carrito
            total = 0;
            for (var i = 0; i < cart.length; i++) {
                var product = cart[i];
                var subtotal = product.price * product.quantity;
                total += subtotal;
                cartContent.innerHTML += '<tr><td><img src="' + product.img + '"/></td><td>' + product.name + '</td><td>$' + product.price + '</td><td><input type="number" min="1" value="' + product.quantity + '" data-product-id="' + product.id + '" class="quantity-input"></td><td>$' + subtotal + '</td><td><button class="remove-button" data-product-id="' + product.id + '">Eliminar</button></td></tr>';
            }
            document.getElementById('total-price').innerText = total;
            document.getElementById('cart-modal').style.display = 'block'; // Mostramos el modal del carrito

            var removeButtons = document.getElementsByClassName('remove-button');
            for (var i = 0; i < removeButtons.length; i++) {
                removeButtons[i].addEventListener('click', function(e) {
                    var productId = e.target.getAttribute('data-product-id');
                    cart = cart.filter(function(product) {
                        return product.id !== productId;
                    });
                    document.getElementById('cart-count').innerText = cart.length;
e.target.parentElement.parentElement.remove();
});
}
var quantityInputs = document.getElementsByClassName('quantity-input');
        for (var i = 0; i < quantityInputs.length; i++) {
            quantityInputs[i].addEventListener('change', function(e) {
                var productId = e.target.getAttribute('data-product-id');
                var newQuantity = e.target.value;
                for (var i = 0; i < cart.length; i++) {
                    if (cart[i].id === productId) {
                        cart[i].quantity = newQuantity;
                        break;
                    }
                }
                // Actualizar el total
                total = 0;
                for (var i = 0; i < cart.length; i++) {
                    var product = cart[i];
                    var subtotal = product.price * product.quantity;
                    total += subtotal;
                }
                document.getElementById('total-price').innerText = total;
            });
        }
    });

    var closeModal = document.getElementsByClassName('close-modal')[0];
    closeModal.addEventListener('click', function() {
        document.getElementById('cart-modal').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        var modal = document.getElementById('cart-modal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
</body>
</html>