document.addEventListener('DOMContentLoaded', function () {
  const pdfjsLib = window['pdfjs-dist/build/pdf'];
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';

  let pdfDoc = null,
      pageNum = 1,
      pageRendering = false,
      pageNumPending = null,
      scale = 1.0,
      canvas = document.getElementById('pdf-canvas'),
      ctx = canvas.getContext('2d');

  const initPDFViewer = (url) => {
      pdfjsLib.getDocument(url).promise.then((pdfDoc_) => {
          pdfDoc = pdfDoc_;
          document.getElementById('page-count').textContent = pdfDoc.numPages;
          renderPage(pageNum);
      });
  };

  const renderPage = (num) => {
      pageRendering = true;
      pdfDoc.getPage(num).then((page) => {
          const viewport = page.getViewport({ scale: scale });
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          const renderContext = {
              canvasContext: ctx,
              viewport: viewport
          };
          const renderTask = page.render(renderContext);

          renderTask.promise.then(() => {
              pageRendering = false;
              if (pageNumPending !== null) {
                  renderPage(pageNumPending);
                  pageNumPending = null;
              }
          });
      });

      document.getElementById('page-num').textContent = num;
  };

  const queueRenderPage = (num) => {
      if (pageRendering) {
          pageNumPending = num;
      } else {
          renderPage(num);
      }
  };

  document.getElementById('prev-page').addEventListener('click', () => {
      if (pageNum <= 1) {
          return;
      }
      pageNum--;
      queueRenderPage(pageNum);
  });

  document.getElementById('next-page').addEventListener('click', () => {
      if (pageNum >= pdfDoc.numPages) {
          return;
      }
      pageNum++;
      queueRenderPage(pageNum);
  });

  document.getElementById('zoom-in').addEventListener('click', () => {
      scale += 0.1;
      queueRenderPage(pageNum);
  });

  document.getElementById('zoom-out').addEventListener('click', () => {
      if (scale <= 0.1) {
          return;
      }
      scale -= 0.1;
      queueRenderPage(pageNum);
  });

  window.initPDFViewer = initPDFViewer;
});
