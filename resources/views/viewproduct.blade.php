<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>View Book</title>
  <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>

  .container {
    display: flex;
    padding: 10px 50px;
    width: 100%;
    @media (max-width: 769px) {
    padding: 0 10px;
  }
  }

  .pdf-viewer {
    width: 60%;
    height: 750px;
    border: 1px solid #ddd;
    }

  .notes-div {
    background-color: rgb(26, 25, 25);
    width: 40%;
    margin-left: 20px;
    border: none;
    border-radius: 10px;

  }

  .notes-name {
    background-color: rgb(37, 37, 37);
    height: 7%;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
  }

.notes-p {
  display: flex;
  padding-left: 20px;
  padding-top: 15px;
  color: white;
  font-family: sans-serif;
  font-weight: 800;
  font-size: 16px;
  text-transform: uppercase;
}

#note-area {
  color: white;
  padding: 20px;
  font-family: sans-serif;
  font-weight: 800;
  font-size: 14px;
  text-transform: uppercase;
  height: 93%;
  width: 100%;
  border: none;
  background-color: rgb(26, 25, 25);
  resize: none; 
}

@media screen and (max-width: 400px) {
  button {
    line-height: 12px;
  }

}

.container-under-pdf-view {
  padding: 10px 50px;
  position: relative;
  @media (max-width: 769px) {
    padding: 0 10px;
  }
}

.under-pdf {
  
  display: flex;
}

.metadata {
  display: flex;
  width: 100%;
  margin-bottom: 20px;
  height: 50px;

}

.metadata h2 {
  font-weight: 800;
  color: white;
  font-family: sans-serif;
}

.metadata button {
  display: inline-block;
  border: none;
  background-color: rgb(37, 37, 37);
  color: white;
  border-radius: 20px;
  justify-content: center;
  align-items: center;
  padding: 10px 30px;
  font-weight: 800;
  font-family: sans-serif;
  height: 38px;
  font-size: 12px;
  margin-left: auto;
}

.about-pdf {
  background-color: rgb(37, 37, 37);
  width: 50%;
  margin-right: 30px;
  color: white;
  position: relative;
  height: 350px;
  border-radius: 20px;
  padding: 10px;
}

.reviews-div {
  background-color: rgb(37, 37, 37);
  width: 50%;
  color: white;
  position: relative;
  height: 350px;
  border-radius: 20px;
  padding: 10px;
  overflow: hidden;
}

.review-card {
  background-color: #1c1a1a;
  padding: 20px;
  border-radius: 20px;
  margin-top: 10px;
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



  </style>
</head>

<body>
  @include('navbar')

  <div class="container">
      <iframe style="border-radius:10px; " class="pdf-viewer" src="/assets/{{$data->file}}"></iframe>

      <div class="notes-div">
        <div class="notes-name">
          <p class="notes-p">notes</p>
        </div>

        <textarea id="note-area"  placeholder="Type anything here..."></textarea>

      </div>
      

  </div>

  <section class="container-under-pdf-view">

    <div class="metadata">
      <h2>{{$data->title}}</h2>
      <button><i class='bx bx-star'></i> FAVORITE</button>
    </div>

    <div class="under-pdf">

      <div style="color: white;" class="about-pdf">
        <h2 style="  font-family: sans-serif; font-weight: 800; font-size: 20px; text-transform: uppercase; margin-bottom: 20px;">ABOUT BOOK</h2>
        <p>TITLE - <b>{{$data->title}}</b></p>
        <p>AUTHOR - <b>{{$data->author}}</b></p>
        <p>CATEGORY - <b>{{$data->category}}</b></p>
      </div>
      <div class="reviews-div">
        <h2 style="  font-family: sans-serif; font-weight: 800; font-size: 20px; text-transform: uppercase;">REVIEWS</h2>

        <div class="review-card">
          <h3>username</h3>
          <p>review text</p>
        </div>
        <div class="review-card">
          <h3>username</h3>
          <p>review text</p>
        </div>
        <div class="review-card">
          <h3>username</h3>
          <p>review text</p>
        </div>
        
      </div>
    </div>

  </section>

  <script>

/*
    const textbox = document.getElementById('note-area');
    
    // Load saved content on page load
    function loadContent() {
      const savedContent = localStorage.getItem('textboxContent');
      if (savedContent) {
        textbox.value = savedContent;
      }
    }
    
    // Save content when changes are made
    function saveContent() {
      localStorage.setItem('textboxContent', textbox.value);
    }
    
    // Call the functions to initialize and save
    loadContent(); 
    textbox.addEventListener('input', saveContent); */
    </script>


  
</body>
</html>