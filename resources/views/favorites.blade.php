<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Favorites</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>

    * {
      padding: 0;
      margin: 0;
      font-family: sans-serif;
      box-sizing: border-box;
    }
  
    body {
      background-color: rgb(0, 0, 0);
        min-width: 375px;
        align-items: center;
        justify-content: center;
        font-family: sans-serif;
  
    }

  .alert-danger {
  color: red;
  font-size: 14px;
  margin-top: 5px;
  width: 100%;
  background-color: #2b0909;
  height: 46px;
  border-radius: 20px;
  padding-left: 20px;
  padding-top: 12px;
  margin-bottom: 10px;
}

.alert-success {
  color: green;
  font-size: 14px;
  margin-top: 10px;
  width: 100%;
  background-color: #072907;
  height: 46px;
  border-radius: 20px;
  padding-left: 20px;
  display: flex;
  padding-top: 12px;
}

  .btn-primary {
    margin-top: 20px;
    border: 1px solid white;
    background-color: white;
    height: 38px;
    width: 100%;
    border-radius: 20px;
    font-weight: 800;
    cursor: pointer;
    font-size: 12px;
    text-transform: uppercase;
    transition: all 0.15;
  }
  
  .login-btn {
    border: 1px solid white;
    background-color: black;
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

  
  .remove-btn {
    color: rgb(255, 0, 0);
    text-decoration: none;
    border: rgb(255, 0, 0) 1px solid;
    border-radius: 20px;
    padding: 10px;
    font-family: sans-serif;
    font-weight: 800;
    font-size: 12px;
    text-transform: uppercase;
    background-color: #1a1a1a;
    cursor: pointer;
  }
  
  .view-btn {
    border: 1px solid rgb(0, 0, 0);
    background-color: rgb(255, 255, 255);
    color: rgb(0, 0, 0);
    padding: 10px;
    border-radius: 20px;
    font-weight: 800;
    font-size: 12px;
    text-transform: uppercase;
    text-decoration: none;
  }

  .favorites-card {
    background-color: rgb(37, 37, 37);
    color: white;

  }

  .navbar {
    display: flex;
    background-color: blueviolet;
    height: 80px;
    padding: 0px 50px;
    @media (max-width: 650px) {
      padding: 0 10px;
    }
  }

  .back-btn-div {
    display: flex;
    margin-top: 20px;
  }

  #back-btn {
    position: absolute;
    height: 40px;
    width: 40px;
    background: white;
    text-align: center;
    color: black;
    line-height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.25rem;
  }

  .main-container {
    background-color: black;
    padding: 0 50px;
    display: flex;
    flex-direction: column;
    width: 100%;
    min-height: 100vh;

    @media (max-width: 650px) {
      padding: 0 10px;
    }
  }

  .text-container{
    background-color: rgb(37, 37, 37);
    color: white;
    text-align: left;
    margin-top: 40px;
    padding: 10px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .item-container {
    background-color: rgb(37, 37, 37);
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
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

.item-card {
    background-color: rgb(0, 0, 0);
    color: white;
    padding: 20px;
    border-radius: 10px;
    border: white 1px solid;
    border-radius: 10px;
    height: 400px;
}


  </style>

</head>
<body>
  <div class="navbar">
    <div class="back-btn-div">
      <span id="back-btn" onclick="window.location.href='{{'/home'}}'" class='bx bxs-left-arrow-alt'></span>
    </div>
  </div>

  <div class="main-container" >

    @if ($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="text-container">
      <h1 style="color: white; text-transform:uppercase; font-family: sans-serif; font-weight: 800;">Favorites</h1>
    </div>

    <div class="item-container">

      @if ($favorites->count() > 0) 
      @foreach ($favorites as $favorite)
          <div class="item-card">
              <h2>{{ $favorite->product->title }}</h2> 
              <p>{{ $favorite->product->author }}</p>
              <p>{{ $favorite->product->category }}</p>
              <form action="{{ route('favorites.delete', $favorite->product_id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="remove-btn" style="margin-top: 5px; ">Remove</button>
              </form>
          </div>
      @endforeach
  @else
      <p style="font-family: sans-serif; font-size: 14px; font-weight: 800; text-transform: uppercase; color: white;">There are no favorites!</p>
  @endif 
  

    </div>

  </div>
  
</body>
</html>