
var level_set_select = document.getElementById('level-set-select');
var level_select = document.getElementById('level-select');

var set_levels = document.querySelectorAll('.set-level');
var level_array = document.querySelectorAll('.level-array');

var change_set_btn = document.getElementById('change-set-btn');

var levelSetId = 0;

async function get_levels() {
  const formData = new FormData();
  formData.append('setID', levelSetId);

  const xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'comps/levels/get_levels.php', true);
  xhttp.onload = function() {
    if (xhttp.status === 200) {
      create_level_options(xhttp.responseText);
    } else {
      console.error('Error updating class');
    }
  };
  xhttp.send(formData);
}

async function create_level_options(levels) {
  levels = JSON.parse(levels);
  var options = [];
  if(!levels.length) {
    level_select.style.display = 'none';
    level_select.replaceChildren(...options);
    return;
  };

  levels.forEach(level => {
    var option = document.createElement('option');
    option.value = level['ID'];
    option.textContent = level.name;
    options.push(option);
  })

  level_select.replaceChildren(...options);

  var option = document.createElement('option');
  option.setAttribute('disabled', "");
  option.setAttribute('selected', "");
  option.textContent = 'Select a level';
  level_select.insertBefore(option, level_select.firstChild);
}

function on_set_change(e) {
  levelSetId = e.target.value;
  set_levels.forEach(function(level) {
    if(level.id === levelSetId) {
      level.style.display = 'flex';
    } else {
      level.style.display = 'none';
    }
  });

  level_array.forEach(level => {
    level.style.display = 'none';
  })

  level_select.style.display = 'flex';
  get_levels();
}

function on_level_change(e) {
  var levelID = e.target.value;
  level_array.forEach(level => {
    level.style.display = 'none';
    if(level.id === levelID) {
      level.style.display = 'flex';
    }
  })
}

function main() {
  if(level_set_select) {
    level_set_select.addEventListener('change', on_set_change);
  }

  if(level_select) {
    level_select.addEventListener('change', on_level_change);
  }

  if (change_set_btn) {
    change_set_btn.addEventListener('click', () => {
      alert('Changing a level set will delete all the progress in the current level!');
    })
  }
}

main();
