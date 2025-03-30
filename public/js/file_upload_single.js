

var selectFileSingle = document.getElementById('select-file-single');

var url = window.location.href;
var params = new URLSearchParams(new URL(url).search);

function upload_file_single(e) {
  e.preventDefault();
  ajax_file_upload_single(e.dataTransfer.files);
}

function file_explorer_single() {
  selectFileSingle.click();
  selectFileSingle.onchange = function() {
    var files = selectFileSingle.files;
    ajax_file_upload_single(files);
  }
}

function ajax_file_upload_single(files_obj) {
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
