
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>View Book</title>
  <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
  <link type="text/css"  rel="stylesheet" href="{{ asset('css/pdf-view.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="{{ asset('pdfjs-express/lib/ui/style.css') }}"/>
  

  <style>
.fab {
    position: fixed;
    bottom: 20px; 
    right: 20px;
    background-color: #1d1d1d; 
    color: white;
    border: none;
    border-radius: 50%;
    padding: 15px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); 
    z-index: 10; 
}

#toggle-button {
            display: none;
        }
@media (max-width: 768px) {
  #toggle-button {
      display: block;
      font-size: 20px;
      position: fixed;
      bottom: 20px; 
      right: 20px;
      background-color: #1d1d1d; 
      color: white;
      border: none;
      border-radius: 50%;
      padding: 15px;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); 
      z-index: 10; 
  }
}

/*
@media (max-width: 768px) { 
  iframe {
    height: 400px; 
    width: 100%;
  }
} */


#pdfContainer {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 900px; 
    overflow: hidden;
}

#pdfFrame {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}


  </style>

</head>

<body>
  @include('navbar')

  <div class="container">
     <!-- <div id="pdfViewer" class="pdf-viewer"></div>-->
     <div id="pdfContainer">
      <iframe id="pdfFrame" src="/assets/{{ $data->file }}#toolbar=0" width="60%" height="750px"></iframe>    
    </div>


      <button id="toggle-button" class="fab">
        <i class="toggle-icon bx bx-notepad"></i>  
      </button>

      <div id="notes-div" class="notes-div">
        <div class="notes-name">
          <p class="notes-p">notes</p>
        </div>
        <textarea id="note-area"  placeholder="Type anything here...">
        </textarea>
      </div>

  </div>

  <section id="underPdf" class="container-under-pdf-view">

    <div class="metadata">
      <h2>{{$data->title}} by {{$data->author}}</h2>
      <button><i class='bx bx-star'></i> FAVORITE</button>
    </div>

    <div class="under-pdf">


      <div id="reviews-div" class="reviews-div">
        <h1 class="reviews-header">REVIEWS</h1>
        @auth
            <form class="review-form" method="POST" action="{{ route('products.reviews.store', $product->id) }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="rating-container">
                    <label class="review-label" for="review_score"></label>
                    <div class="star-rating">
                        @for ($i = 5; $i >= 1; $i--) 
                            <input style="display: none;" type="radio" id="rating-{{ $i }}" name="review_score" value="{{ $i }}" required>
                            <label for="rating-{{ $i }}" class="star">&#9734;</label>
                        @endfor
                    </div>
                </div>
                <div class="review-input-button">
                <textarea class="review-textbox" name="review_text" placeholder="Write your review here..." required></textarea>
                <button class="button-review" type="submit">Submit</button>
                </div>
            </form>
        @else
            <p><a href="{{ route('login') }}">Login</a> to add a review.</p>
        @endauth
            <h3 style="margin-bottom: 8px; font-family: sans-serif; font-weight: 600; text-transform: uppercase;">Sort by</h3>
        <div class="filter-buttons">
          <button id="sort-highest" class="button-filter" onclick="sortReviews('highest')">Highest Rated</button>
          <button id="sort-lowest" class="button-filter" onclick="sortReviews('lowest')">Lowest Rated</button>
      </div>
      <div id="reviews-container">
        @foreach($reviews as $review)
            <div class="review-card" data-score="{{ $review->review_score }}">
              <p class="reviewed-by"> {{ $review->user->name }}</p>
                <div class="star-rating">
                    @for ($i = 1; $i <= $review->review_score; $i++)
                        <span class="star filled" style="color: gold;">&#9733;</span> 
                    @endfor
                    @for ($i = $review->review_score + 1; $i <= 5; $i++)
                        <span class="star">&#9734;</span> 
                    @endfor
                </div>
                <p>{{ $review->review_text }}</p>
                @if (auth()->check() && auth()->id() === $review->user_id)
                    <form method="POST" action="{{ route('products.reviews.destroy', [$product->id, $review->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button-delete">Delete</button>
                    </form>
                @endif
            </div>
        @endforeach
          </div>
    </div>
    
    
    
  

    </div>

  </section>


  <!-- SORT REVIEWS -->
  <script>
    function sortReviews(order) {
        let highestButton = document.getElementById('sort-highest');
        let lowestButton = document.getElementById('sort-lowest');
        let reviewsContainer = document.getElementById('reviews-container');
        let reviews = Array.from(reviewsContainer.getElementsByClassName('review-card'));

        if (order === 'highest') {
            if (highestButton.classList.contains('active')) {
                highestButton.classList.remove('active');
                sortReviews('none');
            } else {
                highestButton.classList.add('active');
                lowestButton.classList.remove('active');
                reviews.sort((a, b) => b.dataset.score - a.dataset.score);
            }
        } else if (order === 'lowest') {
            if (lowestButton.classList.contains('active')) {
                lowestButton.classList.remove('active');
                sortReviews('none');
            } else {
                lowestButton.classList.add('active');
                highestButton.classList.remove('active');
                reviews.sort((a, b) => a.dataset.score - b.dataset.score);
            }
        } else {
            reviews.sort((a, b) => b.dataset.timestamp - a.dataset.timestamp); 
        }

        reviews.forEach(review => reviewsContainer.appendChild(review));
    }

    document.addEventListener('DOMContentLoaded', function () {
        let reviewsContainer = document.getElementById('reviews-container');
        let reviews = Array.from(reviewsContainer.getElementsByClassName('review-card'));

        reviews.forEach(review => {
            review.dataset.timestamp = new Date(review.querySelector('.reviewed-by').dataset.timestamp).getTime();
        });
    });
</script>


<!-- NAVIGATE BUTTON -->
  <script>
  const notesButton = document.getElementById('toggle-button');
  const toggleIcon = notesButton.querySelector('.toggle-icon');

  let isAtNotesSection = false;

  notesButton.addEventListener('click', () => {
      const notesSection = document.getElementById('notes-div');

      if (isAtNotesSection) {
          window.scrollTo({ top: 0, behavior: 'smooth' });
          toggleIcon.classList.replace('bx-book', 'bx-notepad');
      } else {
          notesSection.scrollIntoView({ behavior: 'smooth' });
          toggleIcon.classList.replace('bx-notepad', 'bx-book'); 
      }

      isAtNotesSection = !isAtNotesSection;
  });
  </script>

<!-- PDF SCRIPT -->
<script type="module">
  import { getDocument, GlobalWorkerOptions } from 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.2.67/pdf.min.mjs';

  // (Optional) Configure worker path if needed
  GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.2.67/pdf.worker.min.mjs'; 

  const pdfViewer = document.getElementById('pdfViewer');

  async function loadPdf() {
      const pdfPath = "/assets/{{ $data->file }}";
      const loadingTask = getDocument(pdfPath); // Use getDocument instead of PDFJS.getDocument
      const pdf = await loadingTask.promise;

      for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
          const page = await pdf.getPage(pageNum);
          const viewport = page.getViewport({ scale: 1.0 });

          const canvas = document.createElement('canvas');
          const context = canvas.getContext('2d');
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          const renderTask = page.render({
              canvasContext: context,
              viewport: viewport
          });
          await renderTask.promise;
          pdfViewer.appendChild(canvas);
      }
  }
  
  loadPdf().catch(error => {
      console.error("Error loading PDF:", error); // Add error handling
  });
</script>


<!-- NOTE SCRIPT   -->
  <script>
    $(document).ready(function() {
      const productId = {{ $data->id }};
      let saveTimeout;
  
      $.get(`/notes/${productId}`, function(note) {
        if (note) {
          $('#note-area').val(note.note_text);
        }
      });
  
      $('#note-area').on('input', function() {
        clearTimeout(saveTimeout); 
  
        saveTimeout = setTimeout(function() {
          const noteText = $('#note-area').val();
          saveOrUpdateNote(noteText, productId);  
        }, 1000); 
      });
  
      function saveOrUpdateNote(noteText, productId) {
        $.ajax({
          url: `/notes/${productId}`,
          method: 'PUT',
          data: {
            note_text: noteText,
            product_id: productId,
            _token: "{{ csrf_token() }}" 
          },
          success: function(response) {
            console.log(response.message); 
          }
        });
      }
    });
  </script>
  

</body>
</html>