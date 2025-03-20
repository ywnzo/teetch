var sortForm = document.getElementById('sort-form');
var sort = document.getElementById('sort');

function main() {
  sort.addEventListener('change', function() {
    sortForm.submit();
  });
}

main();
