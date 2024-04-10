<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home Page</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>

    
    <body>

        <style>

        * {
        padding: 0;
        margin: 0;
        font-family: sans-serif;
        box-sizing: border-box;
        }

        body {
        background-color: #1c1a1a;
        min-width: 375px;
        align-items: center;
        justify-content: center;
        font-family: sans-serif;

        }
        .navbar {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 50px;
            background: #1c1a1a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 999;
        }

        h1 {
            color: #fff;
            font-size: 30px;
            text-transform: uppercase;
            font-weight: 700;
            position: relative;
        }


        nav {
            display: flex;
            align-items: center;
        }

        .nav-a a {
            position: relative;
            color: white;
            text-decoration: none;
            margin-left: 30px;
            font-family: sans-serif;
            font-weight: 700;
            cursor: pointer;
            font-size: 17px;
            text-transform: uppercase;
        }

        .nav-a .active {
            border-bottom: 4px solid #ffffff
        }

        .nav-a a::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 4px;
            background: #ffffff;
            transition: 0.2s
        }

        .nav-a a:hover::before {
            width: 100%;
        }

        .register-btn {
            border: 1px solid white;
            background-color: white;
            padding: 10px;
            height: 40px;
            width: 120px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
            transition: all 0.15;
        }

        .login-btn {
            border: 1px solid white;
            background-color: rgb(37, 37, 37);
            color: white;
            padding: 10px;
            height: 40px;
            width: 120px;
            border-radius: 20px;
            font-weight: 800;
            margin-left: 20px;
            font-size: 12px;
            text-transform: uppercase;
            transition: all 0.15;
        }

        button:hover {
            cursor: pointer;
            opacity: 0.7;
        }


        @media (max-width: 850px) {

            .navbar {
                padding: 10px 7.5%;
                flex-direction: column;
                display: flex;
            }

            .navbar .nav-a a {
                display: none;
            }

            .navbar h1 {
                justify-content: center;
                text-align: center;
            }

            .nav-btn{
                display: flex;
                width: 100%;
                margin-top: 1%;
                margin-bottom: 1.5%;
            }

            .login-btn {
                float: left;
                margin-left: 0;
            }


            .navbar button {
                align-items: center;
                justify-content: center;
                width: 100%;
                
                
            }
        }

        p {
            font-weight: 800;
            margin-left: 20px;
            font-size: 12px;
            text-transform: uppercase;
            color: white;
        }

        .item-container {
            background-color: rgb(37, 37, 37);
            border-radius: 10px;
            padding: 16px;
        }

        .item-container2 {
      background-color: rgb(37, 37, 37);
      border-radius: 10px;
      display: grid;
      grid-gap: 16px;
      padding: 16px;
      
      @media (min-width: 768px) {
        grid-template-columns: repeat(2, 1fr);
      }
      
      @media (min-width: 960px) {
        grid-template-columns: repeat(3, 1fr);
      }
      
      @media (min-width: 1200px) {
        grid-template-columns: repeat(4, 1fr);
      }
  }

        .main-container {
            background-color: #1c1a1a;
            padding: 0 50px;
            display: flex;
            flex-direction: column;
            width: 100%;
            height:min-content;
            padding-bottom: 30px;

            @media (max-width: 769px) {
                padding: 0 10px;
            }
        }

    .item-card {
        background-color: #1c1a1a;
        color: white;
        padding: 10px;
        border-radius: 10px;
        border: white 1px solid;
        border-radius: 10px;
        height: 500px;
        position: relative;
    }
        </style>

        <header class="navbar">
            <h1 class="logo" style="font-family: sans-serif; color: white; cursor: pointer; font-weight: 800">LOGO</h1>
    
            <nav class="nav-btn">
                @if (Route::has('login'))

                    @auth
                        <button onclick="window.location.href = '{{ route('home') }}'" class="login-btn">Dashboard</button>
                    @else
                    <button class="login-btn" style="margin-right: 14px;" onclick="window.location.href = '{{ route('login') }}'">Login</button>


                        @if (Route::has('register'))
                            <button onclick="window.location.href = '{{ route('register') }}'" class="register-btn">Register</button>
                        @endif
                    @endauth
                @endif
            </nav>

        </header>

        <div class="main-container">
            <div class="item-container">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus in laboriosam voluptatibus beatae esse. Aperiam, facilis veniam. Soluta deserunt est expedita praesentium tenetur consectetur quisquam consequuntur amet! Soluta, corrupti quam?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus in laboriosam voluptatibus beatae esse. Aperiam, facilis veniam. Soluta deserunt est expedita praesentium tenetur consectetur quisquam consequuntur amet! Soluta, corrupti quam?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus in laboriosam voluptatibus beatae esse. Aperiam, facilis veniam. Soluta deserunt est expedita praesentium tenetur consectetur quisquam consequuntur amet! Soluta, corrupti quam?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus in laboriosam voluptatibus beatae esse. Aperiam, facilis veniam. Soluta deserunt est expedita praesentium tenetur consectetur quisquam consequuntur amet! Soluta, corrupti quam?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus in laboriosam voluptatibus beatae esse. Aperiam, facilis veniam. Soluta deserunt est expedita praesentium tenetur consectetur quisquam consequuntur amet! Soluta, corrupti quam?</p>
            </div>

            <div style="margin-top: 20px;" class="item-container2">
                <div class="item-card">

                </div>
                <div class="item-card">
                    
                </div>
                <div class="item-card">
                    
                </div>
                <div class="item-card">
                    
                </div>
            </div>
        </div>


        
    </body>
</html>
