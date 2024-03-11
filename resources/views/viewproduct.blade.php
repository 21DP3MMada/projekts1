<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>View File</title>

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

}

  .container {
    display: flex;
    padding: 10px 100px;
    width: 100%;
  }

  .pdf-viewer {
    width: 70%;
    height: 750px;
    border: 1px solid #ddd;
    }

  .notes-div {
    background-color: rgb(26, 25, 25);
    width: 30%;
    margin-left: 20px;
    border: none;
    border-radius: 20px;

  }

.notes-name {
  background-color: rgb(37, 37, 37);
  height: 7%;
  border-top-right-radius: 20px;
  border-top-left-radius: 20px;
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

.notes-type {
  color: white;
  padding: 20px;
  font-family: sans-serif;
  font-weight: 800;
  font-size: 14px;
  text-transform: uppercase;
  height: 93%;
  border: none;

}

.back-btn-div {
  display: block;
  margin-top: 0px;
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

@media screen and (max-width: 400px) {
  button {
    line-height: 12px;
  }

}

.container-under-pdf-view {
  padding: 10px 100px;
  position: relative;
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
  background-color: rgb(26, 25, 25);
  width: 50%;
  margin-right: 30px;
  color: white;
  position: relative;
  height: 350px;
  border-radius: 20px;
  padding: 10px;
}

.reviews-div {
  background-color: rgb(26, 25, 25);
  width: 50%;
  color: white;
  position: relative;
  height: 350px;
  border-radius: 20px;
  padding: 10px;
  overflow: hidden;
}

.review-card {
  background-color: rgb(37, 37, 37);
  padding: 20px;
  border-radius: 20px;
  margin-top: 10px;
}
  </style>
</head>

<body>
  <div class="container">
      <iframe class="pdf-viewer" src="/assets/{{$data->file}}"></iframe>

      <div class="notes-div">
        <!--<div class="notes-name">
          <p class="notes-p">notes</p>
        </div>-->
        <div id="notes-type-id" class="notes-type" contenteditable="true" data-placeholder="type your notes here...">
        </div>
      </div>

  </div>

  <section class="container-under-pdf-view">

    <div class="metadata">
      <h2>{{$data->title}}</h2>
      <button>FAVORITE</button>
    </div>

    <div class="under-pdf">
      <div class="about-pdf">
        <h2 style="  font-family: sans-serif;
  font-weight: 800;
  font-size: 20px;
  text-transform: uppercase;
  margin-bottom: 20px;">ABOUT E-BOOK</h2>
        <p>{{$data->title}}</p>
        <p>{{$data->author}}</p>
        <p>hz</p>
      </div>
      <div class="reviews-div">
        <h2 style="  font-family: sans-serif;
  font-weight: 800;
  font-size: 20px;
  text-transform: uppercase;">REVIEWS</h2>
  <!--
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
        -->
      </div>
    </div>

  </section>


  
</body>
</html>