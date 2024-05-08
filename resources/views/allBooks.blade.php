<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>All Books</title>
  <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.2.67/pdf.min.mjs"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.2.67/pdf_viewer.min.css" integrity="sha512-kQO2X6Ls8Fs1i/pPQaRWkT40U/SELsldCgg4njL8zT0q4AfABNuS+xuy+69PFT21dow9T6OiJF43jan67GX+Kw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
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
  
  .pdf-item {
      background-color: #1c1a1a;
      color: white;
      border-radius: 10px;
      border: white 1px solid;
      overflow: hidden;
      position: relative;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: 0.15s;
  }

  .pdf-item:hover {
    transform: scale(1.02); 
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); 
}

  @media (max-width: 600px) {
  .item-container {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
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
      display: none;
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

.pdf-item:hover .info-container  {
  display: block; 
}

.pdf-item:hover .favorite-btn {
  display: block; 
}

.genre-filter-container {
    margin-left: 20px; 
}

.genre-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-btn {
    background-color: #1c1a1a; 
    color: white;
    padding: 12px 15px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-size: 12px;
    text-transform: uppercase;
    font-family: sans-serif;
    font-weight: 800;
    
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #1c1a1a;
    min-width: 160px;
    max-width: 200px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1; 
    text-decoration: none;
    border-radius: 10px;
}

.filter-list {
  text-decoration: none;
  padding: 5px 10px;
  display: flex;
  align-items: center;
  user-select: none;
}

.filter-list:hover {
  background-color: rgb(56, 56, 56);
}

.filter-label {
  font-weight: 800;
  font-family: sans-serif;
  cursor: pointer;
  text-transform: uppercase;
  font-size: 14px;
}


.dropdown-content input[type="checkbox"] {
    margin-right: 5px; 
    text-decoration: none;
}

.genre-dropdown:hover .dropdown-content {
    display: block;
    text-decoration: none;
}


.search-filter-container {
    display: flex;
    align-items: center; 
}

#search-input {
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: none;
  border-radius: 20px;
  font-size: 12px;
  outline: transparent;
  background-color:#1c1a1a;
  margin-bottom: 12px;
  color: white;
  text-transform: uppercase;
  font-family: sans-serif;
  font-weight: 800;
  align-items: center;
  margin-top: 10px;
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
  <div class="search-filter-container">
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Search books...">
    </div>
    <div class="genre-filter-container">
        <div class="genre-dropdown">
            <button class="dropdown-btn">Filter by Genres</button>
            <ul class="dropdown-content">
                <!-- Genre list items will be added here -->
            </ul>
        </div>
    </div>
</div>
</div>

  <div class="item-container" >

    @foreach ($data as $data)
      <div class="pdf-item" data-genre="{{ $data->category }}">
        <div class="thumbnail" data-pdfpath="/assets/{{ $data->file }}" ></div>
        <div class="info-container"> 
          <h5 style="margin-bottom: 10px; font-size: 20px;  color: rgb(255, 255, 255);">{{$data->title ?? ''}}</h5>
          <h5 style="margin-bottom: 10px; font-size: 16px;  color: rgb(255, 255, 255);">{{$data->author ?? ''}}</h5>
          <h5 style="margin-bottom: 10px; font-size: 14px;  color: rgb(255, 255, 255);">{{$data->category ?? ''}}</h5>
          <div class="button-container" style="display: flex; justify-content: space-between;">
            <a class="view-btn" href="{{route('view', $data->id)}}">View</a>
            <a class="download-btn" href="{{route('download', $data->file)}}">Download</a>
          </div>
        </div>
          <form action="{{ route('favorites.add', $data->id) }}" method="POST">
            @csrf
            <button type="submit" class="favorite-btn"><i class='bx bx-star'></i></button>
          </form>
      </div>
      @endforeach
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


<script>
  // Book Search
  $(document).ready(function() {
      $("#search-input").on("keyup", function() {
          let searchTerm = $(this).val().toLowerCase();

          $(".pdf-item").each(function() {
              let title = $(this).find(".info-container h5:first").text().toLowerCase();
              if (title.includes(searchTerm)) {
                  $(this).show();
              } else {
                  $(this).hide();
              }
          });
      });
  });
</script>



<script>
  function filterBooks() {
      const selectedGenres = [];
      const checkboxes = document.querySelectorAll('.dropdown-content input[type="checkbox"]');
      checkboxes.forEach(checkbox => {
          if (checkbox.checked) {
              selectedGenres.push(checkbox.value);
          }
      });
  
      const books = document.querySelectorAll('.pdf-item');
      books.forEach(book => {
          if (selectedGenres.length === 0 || selectedGenres.includes(book.dataset.genre)) {
              book.style.display = 'block';
          } else {
              book.style.display = 'none';
          }
      });
  }
  
  // Add event listener to dropdown content
const dropdownContent = document.querySelector('.dropdown-content');
dropdownContent.addEventListener('click', (event) => {
  const clickedElement = event.target;
  let checkbox;

  // Logic to get checkbox
  if (clickedElement.classList.contains('filter-list') || clickedElement.classList.contains('filter-label')) {
    // If clicked element is  either the list or label, find the checkbox inside
    checkbox = clickedElement.closest('.filter-list').querySelector('input[type="checkbox"]');
  } else if (clickedElement.type === 'checkbox') { 
    // If the clicked element is directly the checkbox
    checkbox = clickedElement; 
  }

  // If we found a checkbox, toggle and filter
  if (checkbox) { 
    checkbox.checked = !checkbox.checked;
    filterBooks();
  }
});
  
  fetch('/get-genres')
      .then(response => response.json())
      .then(genres => {
          const dropdownContent = document.querySelector('.dropdown-content');
          genres.forEach(genre => {
              const listItem = document.createElement('a');
              listItem.className = 'filter-list'; 
              const checkbox = document.createElement('input');
              checkbox.type = 'checkbox';
              checkbox.value = genre;
              checkbox.id = `genre-${genre}`; 
  
              const label = document.createElement('label');
              label.htmlFor = `genre-${genre}`; 
              label.textContent = genre;
              label.className = 'filter-label'; 
  
              listItem.appendChild(checkbox);
              listItem.appendChild(label);
              dropdownContent.appendChild(listItem);
          });
      });
  </script>

  
</body>
</html>