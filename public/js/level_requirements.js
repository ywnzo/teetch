

import { COOKIES } from './cookies.js';

var cookies = new COOKIES();

var url = window.location.href;
var params = new URLSearchParams(new URL(url).search);

var lvl_btns = document.querySelectorAll('.lvl-btn');
var add_req_btns = document.querySelectorAll('.add-req-btn');
var add_req_forms = document.querySelectorAll('.add-req-form');

var req_name_inputs = document.querySelectorAll('.req-name-input');
var edit_btns = document.querySelectorAll('.edit-btn');

var levelID = 0;
var container = null;
var add_req_btn = null;
var add_req_form = null;

var step = 5;

function delay(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

function hide_containers() {
  var containers = document.querySelectorAll('.level-req-container');
  containers.forEach((container) => {
    container.style.display = 'none';
    container.style.height = '0px';
  })
}

function hide_forms() {
  add_req_forms.forEach((form) => {
    form.style.display = 'none';
  });
}

function show_btns() {
  add_req_btns.forEach((btn) => {
    btn.style.display = 'flex';
  });
}

async function expand(element) {
  if(!element) {
    return;
  }
  const computedStyle = window.getComputedStyle(element);
  var start_height = computedStyle.height;

  element.style.display = 'flex';
  element.style.height = 'auto';
  var max_height = parseInt(computedStyle.height);
  element.style.height = start_height;

  var count = (max_height - parseInt(start_height)) / step;
  for(var i = 0; i < count; i++) {
    var height = parseInt(computedStyle.height);
    element.style.height = (height + step) + 'px';
    await delay(0.001);
  }
  document.cookie = 'openedLevel=' + levelID;
}

function on_lvl_btn_click(e) {
  var btn = e.target;
  levelID = btn.id.split('-')[2];
  var current_container = document.getElementById('req-container-' + levelID);

  if(container) {
    if(current_container == container) {
      container.style.display = 'none';
      container.style.height = '0px';
      hide_forms();
      show_btns();
      container = null;
      return;
    }

    container.style.display = 'none';
    container.style.height = '0px';
    hide_forms();
    show_btns();
  }

  container = current_container;
  expand(container);
}

function on_add_req_btn_click(e) {
  var btn = e.target;
  add_req_btn = btn;
  add_req_btn.style.display = 'none';

  add_req_form = document.getElementById('add-req-form-' + levelID);
  add_req_form.style.display = 'flex';
  expand(container);
}

function reload_container() {
  var cookie = cookies.GET_COOKIE('openedLevel');
  if(cookie) {
    levelID = cookie;
    container = document.getElementById('req-container-' + cookie);
    if(container) {
      container.style.display = 'flex';
      container.style.height = 'auto';
    }
  } else {
    document.cookie = "openedLevel=0;";
  }
}

function on_req_name_input_change(e) {
  const formData = new FormData();
  formData.append('ID', e.target.id);
  formData.append('levelID', levelID);
  formData.append('name', e.target.value);

  const xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'comps/levels/update_requirement.php', true);
  xhttp.onload = function() {
    if (xhttp.status === 200) {
      console.log(xhttp.responseText);
    } else {
      console.error('Error updating class');
    }
  };
  xhttp.send(formData);
}

function on_lvl_input_change(e) {
  const formData = new FormData();
  var id = e.id.split('-')[2];
  formData.append('ID', id);
  formData.append('name', e.value);

  const xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'comps/levels/update_level.php', true);
  xhttp.onload = function() {
    if (xhttp.status === 200) {
      console.log(xhttp.responseText);
    } else {
      console.error('Error updating class');
    }
  };
  xhttp.send(formData);
}

async function on_edit_btn_click(e) {
  const btn = e.target;
  var mode = btn.getAttribute('mode');

  var id = btn.id;
  var lvl_btn = document.getElementById('lvl-btn-' + id);
  var lvl_input = document.getElementById('lvl-input-' + id);
  var timeout = 150;

  if(mode === 'start') {
    btn.setAttribute('mode', 'finish');
    btn.innerHTML = '<i class="fa-solid fa-check"></i>'

    lvl_btn.style.opacity = 0;
    setTimeout(() => {
      lvl_btn.style.display = 'none';
      lvl_input.style.display = 'flex';
      lvl_input.style.opacity = 1;
    }, timeout)

    lvl_input.click();
  } else {
    btn.setAttribute('mode', 'start');
    btn.innerHTML = '<i class="fa-solid fa-pen-to-square"></i>';

    lvl_input.style.opacity = 0;
    setTimeout(() => {
      lvl_btn.style.display = 'flex';
      lvl_input.style.display = 'none';
      lvl_btn.style.opacity = 1;
    }, timeout)

    on_lvl_input_change(lvl_input);
    lvl_btn.innerHTML = lvl_input.value;
  }
}

function on_set_name_input_change(e) {
  const formData = new FormData();
  var id = e.target.getAttribute('setID');
  formData.append('ID', id);
  formData.append('name', e.target.value);

  const xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'comps/levels/update_set.php', true);
  xhttp.onload = function() {
    if (xhttp.status === 200) {
      console.log(xhttp.responseText);
    } else {
      console.error('Error updating class');
    }
  };
  xhttp.send(formData);
}

async function main() {
  hide_containers();

  lvl_btns.forEach((btn) => {
    btn.addEventListener('click', on_lvl_btn_click);
  });

  add_req_btns.forEach((btn) => {
    btn.addEventListener('click', on_add_req_btn_click);
  });

  req_name_inputs.forEach((input) => {
    input.addEventListener('focusout', on_req_name_input_change);
  });

  edit_btns.forEach((btn) => {
    btn.setAttribute('mode', 'start');
    btn.addEventListener('click', on_edit_btn_click);
  });

  var set_name_input = document.querySelector('.set-name-input');
  if(set_name_input) {
    set_name_input.addEventListener('focusout', on_set_name_input_change);
  }

  reload_container();
}

main();
