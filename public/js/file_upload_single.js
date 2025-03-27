var selectFile = document.getElementById('select-file');

var url = window.location.href;
var params = new URLSearchParams(new URL(url).search);

function upload_file(e) {
  e.preventDefault();
  ajax_file_upload(e.dataTransfer.files);
}

function file_explorer() {
  selectFile.click();
  selectFile.onchange = function() {
    var files = selectFile.files;
    ajax_file_upload(files);
  }
}

function ajax_file_upload(files_obj) {
    if(files_obj === undefined) {
      return;
    }
    console.log(files_obj)
    const form_data = new FormData();

    form_data.append('file', files_obj[0]);

    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "comps/profile_img_upload.php", true);
    xhttp.onload = function(event) {
      if (xhttp.status == 200) {
        console.log(xhttp.responseText);
        //window.location.href = window.location.href;
      } else {
        alert("Error " + xhttp.status + " occurred when trying to upload your file.");
      }
    }

    xhttp.send(form_data);
}

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
