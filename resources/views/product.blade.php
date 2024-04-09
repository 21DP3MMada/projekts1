<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Upload Page</title>
  <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
  .upload-div {
    display: block;
  }

  .upload-text {
    color: white;
    text-transform: uppercase;
    font-weight: 800;
    margin-bottom: 20px;
  }
  .upload-book-form {
    border: rgb(255, 255, 255) 1px solid;
    background-color: #1c1a1a;
    padding: 15px;
    border-radius: 8px;
    display: block;
    color: white;
  }
  .form-group {
  margin-bottom: 10px;
}

  .form-control {
  width: 100%;
  height: 38px;
  background-color: rgb(37, 37, 37);
  border: none;
  border-radius: 20px;
  font-size: 12px;
  outline: transparent;
  text-align: center;
  color: white;
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

.download-btn {
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

.item-container {
    background-color: rgb(37, 37, 37);
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    display: grid;
    grid-gap: 16px;
    padding: 16px;
    
    @media (min-width: 769px) {
    	grid-template-columns: repeat(2, 1fr);
    }
    
    @media (min-width: 961px) {
    	grid-template-columns: repeat(3, 1fr);
    }
    
    @media (min-width: 1201px) {
    	grid-template-columns: repeat(4, 1fr);
    }
}

.item-card {
    background-color: #1c1a1a;
    color: white;
    padding: 20px;
    border-radius: 10px;
    border: white 1px solid;
    border-radius: 10px;
    height: 400px;
}
  </style>
</head>


<div class="navbar">

  <div class="back-btn-div">
    <span id="back-btn" onclick="window.location.href='{{'/home'}}'" class='bx bxs-left-arrow-alt'></span>
  </div>

  @auth 
    <nav class="nav-btn">
        <button class="user-btn" id="dropdown-toggle">
            {{ Auth::user()->name }}
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" onclick=	" window.location.href='{{'/home'}}'">{{ __('Dashboard') }}</a> 
            <a class="dropdown-item" onclick="window.location.href='{{'/profile'}}'">{{ __('Profile') }}</a> 
            <a style="color: red;" class="dropdown-item-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> 
                @csrf 
            </form>
        </div>
      </nav>
  @endauth



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#dropdown-toggle').click(function () {
    $(this).next('.dropdown-menu').toggle();
  });
</script>

  <div class="main-container">
    @if ($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
      <h1 style="color: white; text-transform:uppercase; font-family: sans-serif; font-weight: 800;">Upload Book</h1>
    </div>
    <div class="item-container">

      <div class="upload-div">
    
      <form class="upload-book-form" action="{{url('uploadbook')}}" method="post" enctype="multipart/form-data"> 

        @csrf
        <div class="form-group" style="margin-bottom: 18px;">
          <input class="form-control" style="height: 42px;" type="text" name="title" placeholder="Title">
        </div>
        <div class="form-group" style="margin-bottom: 18px;">
          <input class="form-control" style="height: 42px;" type="text" name="author" placeholder="Author">
        </div>
        <div class="form-group" style="margin-bottom: 18px;">
          <select class="form-control" name="category" style="height: 42px; color:gray;">
              <option value="">Select Category</option>
              <option value="pirma kateg">1</option>
              <option value="otra kateg">2</option>
              <option value="tresa kateg">3</option>
          </select>
      </div>

        <input type="file" name="file">

        <div class="form-btn">
          <input class="btn-primary" type="submit" value="UPLOAD">
        </div>

      </form>

    </div>
  </div>

    <div class="text-container">
      <h1 style="color: white; text-transform:uppercase; font-family: sans-serif; font-weight: 800;">Manage Books</h1>
    </div>

    <div class="item-container">

      @foreach ($data as $data)
        <div class="item-card">
          <h5 style="margin-bottom: 10px; font-size: 1.2em;  color: rgb(255, 255, 255);">{{$data->title ?? ''}}</h5>
          <h5 style="margin-bottom: 10px; font-size: 1.2em;  color: rgb(255, 255, 255);">{{$data->author ?? ''}}</h5>
          <h5 style="margin-bottom: 10px; font-size: 1.2em;  color: rgb(255, 255, 255);">{{$data->category ?? ''}}</h5>
          <div style="display: flex; justify-content: space-between;">
            <a class="view-btn" href="{{route('view', $data->id)}}">View</a>
            <a class="download-btn" href="{{route('download', $data->file)}}">Download</a>
            <form action="{{ route('delete', $data->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="remove-btn" type="submit">Remove</button>
          </form>
          <form action="{{ route('favorites.add', $data->id) }}" method="POST">
            @csrf
            <button type="submit" class="favorite-btn"><i class='bx bx-star'></i></button>
          </form>
          </div>
        </div>
        @endforeach
    </div>


  </div>
  
</body>
</html>