var addTimeBtn = document.getElementById('add-time-btn');
var day = document.getElementById('day');
var timeStart = document.getElementById('time-start');
var timeEnd = document.getElementById('time-end');

function reload_index() {
  var hiddens = document.querySelectorAll('.time-hidden');
  for(var i = 0; i < hiddens.length; i++) {
    hiddens[i].name = 'time ' + i;
  }
}

function on_time_click(e) {
  e.target.remove();
  reload_index();
}

function create_time() {
  var timeElement = document.createElement('div');
  timeElement.textContent = day.value + ', ' + timeStart.value + ' - ' + timeEnd.value;
  timeElement.classList.add('clickable');
  timeElement.classList.add('time');
  timeElement.addEventListener('click', on_time_click);
  document.getElementById('time-container').appendChild(timeElement);

  var hidden = document.createElement('input');
  hidden.type = 'hidden';
  var index = document.querySelectorAll('.time').length <= 0 ? 0 :(document.querySelectorAll('.time').length - 1)
  hidden.name = 'time' + index;
  hidden.classList.add('time-hidden');
  hidden.value = day.value + ', ' + timeStart.value + ' - ' + timeEnd.value;
  timeElement.appendChild(hidden);
}

function main() {
  if(!addTimeBtn) return;
  addTimeBtn.addEventListener('click', (e) => {
    if(!day || !timeStart || !timeEnd) {
      return;
    }
    if(!day.value || !timeStart.value || !timeEnd.value) {
      alert('Enter all fields');
      return;
    }
    if(timeStart.value > timeEnd.value) {
      alert('Start time must be before end time');
      return;
    }
    if(timeStart.value === timeEnd.value) {
      alert('Start time must be before end time');
      return;
    }
    create_time();
  })
}

main();
