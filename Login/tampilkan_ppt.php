<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display PDF</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.js"></script>
</head>
<body>
    <h1>PDF Viewer</h1>

    <?php
    // PDF file URL
    $pdfUrl = '../assets/img/ESD Training Modul 25_07_2023_.pdf';
    ?>

    <div id="pdf-viewer-container">
            <embed src="<?php echo $pdfUrl; ?>" type="application/pdf" width="100%" height="600px" />
        </div>

    <script>
        // PDF.js code to display the PDF file
        const pdfUrl = '<?php echo $pdfUrl; ?>';

        // Fetch the PDF document
        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc) {
            // Set up the viewer
            const pdfViewer = document.getElementById('pdf-viewer');
            const pdfPageNumber = 1;

            // Load the first page
            pdfDoc.getPage(pdfPageNumber).then(function(page) {
                const viewport = page.getViewport({ scale: 1.5 });
                const canvas = document.getElementById('pdf-viewer');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                page.render(renderContext);
            });
        });
    </script>
</body>
</html>
