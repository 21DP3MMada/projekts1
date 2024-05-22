
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>View Book</title>
  <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pdf-view.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="/js/pdfjs/web/viewer.css"/>

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


/* Hide the toggle button by default */
#toggle-button {
            display: none;
        }

        /* Show the toggle button only on screens 768px wide or less */
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

  </style>

</head>

<body>
  @include('navbar')

  <div class="container">
      <div id="pdfViewer" class="pdf-viewer"></div>

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
      <h2>{{$data->title}}</h2>
      <button><i class='bx bx-star'></i> FAVORITE</button>
    </div>

    <div class="under-pdf">

      <div style="color: white;" id="about-pdf" class="about-pdf">
        <h2 style="  font-family: sans-serif; font-weight: 800; font-size: 20px; text-transform: uppercase; margin-bottom: 20px;">ABOUT BOOK</h2>
        <p>TITLE - <b>{{$data->title}}</b></p>
        <p>AUTHOR - <b>{{$data->author}}</b></p>
        <p>CATEGORY - <b>{{$data->category}}</b></p>
      </div>
      <div id="reviews-div" class="reviews-div">
        <h2 style="  font-family: sans-serif; font-weight: 800; font-size: 20px; text-transform: uppercase;">REVIEWS</h2>

    @auth  
        <h3>Add your review</h3>
        <form class="review-form" method="POST" action="{{ route('products.reviews.store', $product->id) }}">
            @csrf
            
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <label class="review-label" for="review_score">Rating:</label>
            <select class="review-counter" name="review_score" required>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select> 
            <textarea class="review-textbox" name="review_text" required></textarea> 
            <button class="button-review" type="submit">Submit</button>
        </form>

    @else
        <p><a href="{{ route('login') }}">Login</a> to add a review.</p>
    @endauth

    @foreach($reviews as $reviews)
      <div class="review-card">
        <p><b>Rating:</b> {{ $reviews->review_score }}</p>
        <p>{{ $reviews->review_text }}</p>
        <p><i>Reviewed by {{ $reviews->user->name }}</i></p>
      </div> 
    @endforeach
    
        
      </div>
    </div>

  </section>

  <script>
const notesButton = document.getElementById('toggle-button');
const toggleIcon = notesButton.querySelector('.toggle-icon');

let isAtNotesSection = false;

notesButton.addEventListener('click', () => {
    const notesSection = document.getElementById('notes-div');

    if (isAtNotesSection) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        toggleIcon.classList.replace('bx-book', 'bx-notepad'); // Change icon to notepad
    } else {
        notesSection.scrollIntoView({ behavior: 'smooth' });
        toggleIcon.classList.replace('bx-notepad', 'bx-book'); // Change icon to book
    }

    isAtNotesSection = !isAtNotesSection;
});
  </script>


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