<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- Icon title --}}
        <link rel="shortcut icon" href="/img/Logo oficial.png" />
        <title>@yield('title')</title>



        {{-- Links bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        {{-- link nossa aplicação --}}
        <link rel="stylesheet" href="/css/style.css">

    </head>
    <body>
        @php
            $total_pedido=$total_pedido ?? 0;
        @endphp
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><img style="max-width:50px" src="/img/Logo oficial.png" alt="Home"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/"><i class="bi bi-house"></i> Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/contato')}}"><i class="bi bi-telephone"></i> Contato</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-tags"></i> Produtos</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{url('/produtos')}}">Todos os produtos</a></li>
                        @foreach($categorias as $cate)
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/produtos/{{$cate->id}}">{{$cate->nome}}</a></li>
                        @endforeach
                    </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/carrinho')}}"><i class="bi bi-cart"></i> Carrinho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/events/create')}}">Teste create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/carrinho/compras"><i class="bi bi-bag"></i> Minhas Compras</a>
                    </li>
                </ul>
                {{-- Parte de login e cadastro --}}
                @if (Route::has('login'))
                    <div class="menuLogin">
                        @auth
                            <a href="{{ url('/dashboard') }}" style="color:black; display: inline-flex;" class="nav-link text-sm underline">Meu Perfil</a>
                            <form action="/logout" method="POST" class="nav-link" style=" display: inline-flex;">
                                @csrf
                                <a href="/logout" onclick="event.preventDefault(); this.closest('form').submit();"
                                class="menuMargin text-sm underline">Sair</a>
                            </form>
                @else
                    <a href="{{ route('login') }}" class="menuMargin text-sm underline">Entrar</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="menuMargin text-sm underline">Cadastrar</a>
                @endif
                        @endauth
                    </div>
                @endif
                </div>
            </div>
        </nav>
        <div class="container" style="margin-top:10px;">
            <form class="d-flex" action="/produtos" style="margin-bottom:20px;" method="GET">
                <input class="form-control me-2" type="search" name="search" id="search" placeholder="Procure pelo nome do produto" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>


        <div class="container-fluid">
            <div class="row">
                @if(session('msg'))
                    <p class="msg alert alert-success" id="alerta">{{session('msg')}}</p>
                @endif
            </div>
            @yield('content')

        </div>
        <script>
            setTimeout(() => {
                $('#alerta').alert('close');
            }, 3000);
        </script>
        <script src="/js/javascript.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        @stack('scripts')
        <script>
            $(document).ready(function(){
                $(".button-collapse").sideNav();
                $('select').material_select();
            });
        </script>
        <!-- Include the PayPal JavaScript SDK -->
        <script src="https://www.paypal.com/sdk/js?client-id=test&currency=BRL"></script>

        <script>
            // Listen for changes to the radio fields
            document.querySelectorAll('input[name=payment-option]').forEach(function(el) {
                el.addEventListener('change', function(event) {

                    // If PayPal is selected, show the PayPal button
                    if (event.target.value === 'paypal') {
                        document.querySelector('#card-button-container').style.display = 'none';
                        document.querySelector('#paypal-button-container').style.display = 'inline-block';
                    }

                    // If Card is selected, show the standard continue button
                    if (event.target.value === 'card') {
                        document.querySelector('#card-button-container').style.display = 'inline-block';
                        document.querySelector('#paypal-button-container').style.display = 'none';
                    }
                });
            });

            // Hide Non-PayPal button by default
            document.querySelector('#card-button-container').style.display = 'none';
            // Render the PayPal button into #paypal-button-container
            paypal.Buttons({

                locale: 'pt_BR',

                // Set up the transaction
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: {{$total_pedido}}
                            }
                        }]
                    });
                },

                // Finalize the transaction
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        // Successful capture! For demo purposes:
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        let transaction = orderData.purchase_units[0].payments.captures[0];
                        alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                        // Replace the above to show a success message within this page, e.g.
                       const element = document.getElementById('paypal-button-container');
                       element.innerHTML = '';
                       element.innerHTML = '<h3>Obrigado por comprar com a QuazTec!</h3>';
                       document.getElementById("concluirCompra").submit();
                    });
                }


            }).render('#paypal-button-container');
        </script>
        <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
        <script src="/js/jquery.mask.js"></script>
        <script>
            $(document).ready(function(){
                $('#cep').mask('00.000-000');
                $('#cpf').mask('000.000.000-00');
            });
        </script>
    </body>
</html>
