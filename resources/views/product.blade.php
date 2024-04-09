<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
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

  .navbar {
    display: flex;
    background-color: blueviolet;
    height: 80px;
    padding: 0px 50px;
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

  .container {
    display: flex;
    padding: 10px 50px;
    width: 100%;
  }

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
    background-color: rgb(0, 0, 0);
    padding: 15px;
    border-radius: 8px;
    display: block;
    width: 450px;
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
  margin-top: 5px;
  width: 100%;
  background-color: #072907;
  height: 46px;
  border-radius: 20px;
  padding-left: 20px;
  display: flex;
  padding-top: 12px;
  margin-bottom: 10px;
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
  </style>
</head>


<body>
  <div class="navbar">
    <div class="back-btn-div">
      <span id="back-btn" onclick="window.location.href='{{'/home'}}'" class='bx bxs-left-arrow-alt'></span>
    </div>
  </div>

  <div style="flex-direction: column;" class=container>

    <div class="upload-div">
      <h2 class="upload-text">
          Upload Book
      </h2>

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


    <h2 style="margin-top: 20px" class="upload-text">
      Manage Books
    </h2>

    <div style="display: flex; flex-wrap: wrap;">

      @foreach ($data as $data)
        <div style="display: flex; flex-direction: column; margin-right: 20px; width: 250px; height: 300px; border: rgb(255, 255, 255) 1px solid; padding: 5px; border-radius: 8px" class="book-card">
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