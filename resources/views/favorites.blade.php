<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Favorites</title>
  <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.2.67/pdf.min.mjs"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.2.67/pdf_viewer.min.css" integrity="sha512-kQO2X6Ls8Fs1i/pPQaRWkT40U/SELsldCgg4njL8zT0q4AfABNuS+xuy+69PFT21dow9T6OiJF43jan67GX+Kw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>


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
    display: none;
    position: absolute;
    top: 0;
    right: 0;
    color: rgb(255, 0, 0);
    text-decoration: none;
    border: rgb(255, 0, 0) 1px solid;
    border-radius: 20px;
    margin-right: 5px;
    margin-top: 10px;
    padding: 5px;
    font-family: sans-serif;
    font-weight: 800;
    font-size: 20px;
    text-transform: uppercase;
    background-color: #1a1a1a;
    cursor: pointer;
    width: 40px;
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

  .item-container {
      background-color: rgb(37, 37, 37);
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
      grid-gap: 20px; 
      justify-content: start; 
      padding: 20px; 
  }

  @media (max-width: 600px) {
  .item-container {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
}

.item-card {
  background-color: #1c1a1a;
      color: white;
      border-radius: 10px;
      border: white 1px solid;
      overflow: hidden;
      position: relative;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: 0.15s;
  }

.item-card:hover {
  transform: scale(1.02); 
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); 
}

.button-container {
      display: flex;
      bottom: 0;
      left: 0;
      margin-bottom: 10px;
      margin-left: 10px;
  }

  .thumbnail img {
  max-width: 100%; 
  height: auto;  
  width: 100%; 
}

.info-container {
  display: none; 
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 10px;
  background-color: rgba(0, 0, 0, 0.9); 
  border-radius: 0 0 10px 10px; 
  
}

.info-container {
    transition: opacity 0.3s ease-in-out;
}

.item-card:hover .info-container  {
  display: block; 
}

.item-card:hover .remove-btn {
  display: block;
}
  </style>

</head>
<body>

  @include('navbar')

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
            <div class="thumbnail" data-pdfpath="/assets/{{ $favorite->product->file }}" ></div>
            <div class="info-container">
              <h2>{{ $favorite->product->title }}</h2> 
              <p>{{ $favorite->product->author }}</p>
              <p>{{ $favorite->product->category }}</p>
              <div class="button-container" style="display: flex; justify-content: space-between;">
                <a class="view-btn" href="{{route('view', $favorite->product->id)}}">View</a>
              </div>
            </div>
              <form action="{{ route('favorites.delete', $favorite->product_id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="remove-btn" style="margin-top: 5px; "><i class='bx bx-trash'></i></button>
              </form>
          </div>
      @endforeach
  @else
      <p style="font-family: sans-serif; font-size: 14px; font-weight: 800; text-transform: uppercase; color: white;">There are no favorites!</p>
  @endif 
  

    </div>

  </div>

  <script type="module">
    //Book Thumbnails
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.2.67/pdf.worker.min.mjs';
    function generateThumbnail(pdfPath) {
      pdfjsLib.getDocument(pdfPath).promise.then(function(pdf) {
        pdf.getPage(1).then(function(page) {
          var scale = 1; 
          var viewport = page.getViewport({ scale: scale });
          var canvas = document.createElement('canvas');
          var context = canvas.getContext('2d');
  
          canvas.height = viewport.height;
          canvas.width = viewport.width;
  
          var renderContext = {
            canvasContext: context,
            viewport: viewport
          };
  
          page.render(renderContext).promise.then(function() {
            
            var thumbnailImg = document.createElement('img');
            thumbnailImg.src = canvas.toDataURL(); 

            var thumbnailDiv = document.querySelector('.thumbnail[data-pdfpath="' + pdfPath + '"]');
            thumbnailDiv.innerHTML = ''; 
            thumbnailDiv.appendChild(thumbnailImg); 
          });
        });
      }).catch(function(error) {
          console.error("Error loading PDF:", error);
      });
    }
  
    
    document.querySelectorAll('.thumbnail[data-pdfpath]').forEach(function(thumbnailDiv) {
      var pdfPath = thumbnailDiv.dataset.pdfpath;
      generateThumbnail(pdfPath);
    });
  </script>
  
</body>
</html>