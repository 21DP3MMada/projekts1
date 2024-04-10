<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>All Books</title>
  <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <style>

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
      background-color: #1c1a1a;
      color: white;
      padding: 10px;
      border-radius: 10px;
      border: white 1px solid;
      border-radius: 10px;
      height: 400px;
      position: relative;
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
  
    .download-btn {
      margin-left: 10px;
      display: inline-flex;
      color: white;
      text-decoration: none;
      border: white 1px solid;
      border-radius: 20px;
      padding: 10px;
      font-family: sans-serif;
      font-weight: 800;
      font-size: 12px;
      text-transform: uppercase;
    }
    
    .view-btn {
      display: inline-flex;
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

    .favorite-btn {
      position: absolute;
      background-color: rgb(37, 37, 37);
      color: white;
      border: none;
      top: 0;
      right: 0;
      margin-right: 10px;
      margin-top: 10px;
      padding: 5px;
      height: 40px;
      width: 50px;
      border-radius: 20px;
      font-weight: 800;
      margin-left: 20px;
      font-size: 16px;
      text-transform: uppercase;
      transition: all 0.15;
    }

    .favorite-btn:hover {
      background-color: rgb(56, 56, 56);
      cursor: pointer;
    }

    .button-container {
      position: absolute;
      bottom: 0;
      left: 0;
      margin-bottom: 10px;
      margin-left: 10px;
  }
    </style>
</head>

<body>
  @include('navbar')

  <div class="main-container">

@if(session('error'))
    <div class="alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="text-container">
  <h1 style="color: white; text-transform:uppercase; font-family: sans-serif; font-weight: 800;">All Books</h1>
</div>

  <div class="item-container">

    @foreach ($data as $data)
      <div class="item-card">
        <h5 style="margin-bottom: 10px; font-size: 1.2em;  color: rgb(255, 255, 255);">{{$data->title ?? ''}}</h5>
        <h5 style="margin-bottom: 10px; font-size: 1.2em;  color: rgb(255, 255, 255);">{{$data->author ?? ''}}</h5>
        <h5 style="margin-bottom: 10px; font-size: 1.2em;  color: rgb(255, 255, 255);">{{$data->category ?? ''}}</h5>
        <div class="button-container" style="display: flex; justify-content: space-between;">
          <a class="view-btn" href="{{route('view', $data->id)}}">View</a>
          <a class="download-btn" href="{{route('download', $data->file)}}">Download</a>
        </div>
          
          <form action="{{ route('favorites.add', $data->id) }}" method="POST">
            @csrf
            <button type="submit" class="favorite-btn"><i class='bx bx-star'></i></button>
          </form>
      </div>
      @endforeach
  </div>
  </div>
  
</body>
</html>