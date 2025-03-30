var scheduleRows = document.querySelectorAll('.schedule-row-wrapper');

function rand_color() {
    var colors = ['red', 'green', 'blue', 'yellow', 'cyan', 'orange'];
    return colors[Math.floor(Math.random() * colors.length)];
}

function main() {
  scheduleRows.forEach(row => {
    var color = rand_color();
    row.addEventListener('mouseover', () => {
      color = rand_color();
      row.classList.add(color);
    })
    row.addEventListener('mouseout', () => {
      row.classList.remove(color);
    })
  })
}

main();
console.log('Hello there :)');
