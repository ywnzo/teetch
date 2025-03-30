
var addBtns = document.querySelectorAll('.add-btn');
var addWrappers = document.querySelectorAll('.add-wrapper');

var updateTexts = document.querySelectorAll('.update-text');
var deleteBtns = document.querySelectorAll('.update-delete-btn');
var editBtns = document.querySelectorAll('.update-edit-btn');

var url = window.location.href;
var params = new URLSearchParams(new URL(url).search);
var classID = params.get('class');
var lessonID = params.get('lesson');

var startEditIcon = 'fa-pen-to-square';
var stopEditIcon = 'fa-check';

function delete_update(id) {
  const formData = new FormData();
  formData.append('classID', classID);
  if(lessonID){
    formData.append('lessonID', lessonID);
  }
  formData.append('updateID', id);

  const xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'comps/updates/delete_update.php', true);
  xhttp.onload = function() {
    if (xhttp.status === 200) {
      console.log(xhttp.responseText);
      window.location.reload();
    } else {
      console.error('Error deleting class');
    }
  };
  xhttp.send(formData);
}

function update_update(id, text, content) {
  const formData = new FormData();
  table = lessonID ? 'lessonUpdates' : 'classUpdates';
  formData.append('table', table);

  formData.append('text', text);
  formData.append('updateID', id);
  formData.append('content', content);

  const xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'comps/updates/update_update.php', true);
  xhttp.onload = function() {
    if (xhttp.status === 200) {
      console.log(xhttp.responseText);
    } else {
      console.error('Error updating class');
    }
  };
  xhttp.send(formData);
}

function remove_focus(e) {
  e.target.blur();
}

function resize_textarea(area) {
  area.parentNode.dataset.replicatedValue = area.value
}

function open_link(e) {
  var link = e.target.value;
  if(!link.includes('https://') && !link.includes('http://')) {
    link = 'https://' + link;
  }
  window.open(link, '_blank');

}

function stop_edit(e) {
  var btn = e.target.btn;
  var id = btn.getAttribute('id');
  var text = document.getElementById(id.toString());

  var icon = btn.getElementsByClassName(stopEditIcon)[0];
  icon.classList.remove(stopEditIcon);
  icon.classList.add(startEditIcon);

  if(text.classList.contains('update-link')) {
    text.addEventListener('click', open_link);
    text.addEventListener('focus', remove_focus);
    text.classList.add('horizontal');
    var content = 'link';
  } else {
    text.style.pointerEvents = 'none';
    var content = 'text';
  }
  btn.addEventListener('click', start_edit);
  btn.removeEventListener('click', stop_edit);

  update_update(id, text.value, content);
}

function start_edit(e) {
  var btn = e.target.btn;
  var id = btn.getAttribute('id');
  var text = document.getElementById(id.toString());

  var icon = btn.getElementsByClassName(startEditIcon)[0];
  icon.classList.add(stopEditIcon);
  icon.classList.remove(startEditIcon);

  if(text.classList.contains('update-link')) {
    text.removeEventListener('click', open_link);
    text.removeEventListener('focus', remove_focus)
    text.classList.remove('horizontal');
  } else {
    text.style.pointerEvents = 'auto';
  }
  text.focus();


  btn.removeEventListener('click', start_edit);
  btn.addEventListener('click', stop_edit);
}

function load_add_btns() {
  addBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      var typeBtn = btn.getAttribute('cat');
      addWrappers.forEach(wrapper => {
        var typeWrapper = wrapper.getAttribute('cat');
        wrapper.style.display = typeWrapper === typeBtn ? 'flex' : 'none';
      })

      document.querySelector('#update-text').value = '';
      //document.querySelector('#update-link').value = '';
    })
  })
}

function load_control_btns() {
  deleteBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      var id = btn.getAttribute('id');
      delete_update(id);
    })
  })

  editBtns.forEach(btn => {
    btn.addEventListener('click', start_edit);
    btn.btn = btn;
  })
}

function callback(value) {
  alert(value);
}

function scroll_to_bottom() {
  document.querySelector('.page-btn-container').scrollIntoView();
}

function main() {
  if(params.get('offset')) {
    //scroll_to_bottom()
  }

  load_add_btns();
  load_control_btns();

  document.querySelectorAll('.update-text').forEach(text => {
    resize_textarea(text)
    text.addEventListener('keyup', () => {
      resize_textarea(text)
    })
  })

  document.querySelectorAll('.update-link').forEach(link => {
    link.addEventListener('click', open_link);
    link.classList.add('horizontal');
    link.addEventListener('focus', remove_focus)
  })
}

main();
