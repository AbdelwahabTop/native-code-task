function displayPDF() {
  var fileInput = document.getElementById("pdf");
  var file = fileInput.files[0];
  var reader = new FileReader();

  reader.onload = function (e) {
    var pdfContainer = document.getElementsByTagName("iframe")[0];

    // Using <embed> element
    // pdfContainer.innerHTML = '<embed src="' + e.target.result + '" width="100%" height="600px" type="application/pdf" />';

    // Using <iframe> element
    pdfContainer.src = e.target.result;
  };
  reader.readAsDataURL(file);
}

document.getElementById("pdf").addEventListener("change", displayPDF);
