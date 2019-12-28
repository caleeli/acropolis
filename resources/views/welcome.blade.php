<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #024b42;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .circle {
                background-color: #B9C5D6;
                color: white;
                width: 20vw;
                height: 20vw;
                border-radius: 50%;
                font-size: 15vw;
                display: inline-block;
                padding-left: 6px;
                padding-right: 6px;
                padding-top: 12px;
                padding-bottom: 0px;
            }
            .login {
                background-color: #B9C5D6;
            }
            .register {
                background-color: #CDA7B6;
            }
            .circle-container {
                display: inline-block;
                padding: 0px 8px;
                font-size: 5vw;
                text-align: center;
                color: lightgray;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <img src="/images/logo.jpeg" style="width:50vw">
                </div>

                @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <span class="circle-container">
                            <a id="login" href="{{ route('login') }}" class="circle login"><i class="far fa-user"></i></a><br>
                            Ingresar
                        </span>
                        @if (Route::has('register'))
                        <span class="circle-container">
                            <a id="register" href="{{ route('register') }}" class="circle register"><i class="far fa-registered"></i></a><br>
                            Registrarse
                        </span>
                        @endif
                    @endauth
                </span>
                @endif
            </div>
        </div>

    </body>
</html>
