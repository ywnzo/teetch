var selectFile = document.getElementById('select-file');

var url = window.location.href;
var params = new URLSearchParams(new URL(url).search);
var table = url.includes('lesson_plan.php') ? 'lessonUpdates' : 'classUpdates';

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
    const form_data = new FormData();
    for(i=0; i<files_obj.length; i++) {
      form_data.append('classID', params.get('class'));
      form_data.append('lessonID', params.get('lesson'));
      form_data.append('file[]', files_obj[i]);
      form_data.append('table', table);
    }
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "comps/file_upload.php", true);
    xhttp.onload = function(event) {
      if (xhttp.status == 200) {
        console.log(xhttp.responseText);
        window.location.href = window.location.href;
      } else {
        alert("Error " + xhttp.status + " occurred when trying to upload your file.");
      }
    }

    xhttp.send(form_data);
}

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
