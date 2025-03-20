var addTimeBtn = document.getElementById('add-time-btn');
var day = document.getElementById('day');
var timeStart = document.getElementById('time-start');
var timeEnd = document.getElementById('time-end');

var index = 0;

function reload_index() {
  var hiddens = document.querySelectorAll('.time-hidden');
  for(var i = 0; i < hiddens.length; i++) {
    hiddens[i].name = 'time ' + i;
  }
}

function create_time() {
  var timeElement = document.createElement('div');
  timeElement.textContent = day.value + ', ' + timeStart.value + ' - ' + timeEnd.value;
  timeElement.classList.add('clickable');
  timeElement.classList.add('time');
  document.getElementById('time-container').appendChild(timeElement);

  var hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'time' + index;
  hidden.classList.add('time-hidden');
  hidden.value = day.value + ', ' + timeStart.value + ' - ' + timeEnd.value;
  document.getElementById('time-container').appendChild(hidden);
  index += 1;
  timeElement.addEventListener('click', () => {
    timeElement.remove();
    hidden.remove();
    index -= 1;
    reload_index();
  });

}

function main() {
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
