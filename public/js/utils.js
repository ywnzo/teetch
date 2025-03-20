function GET_PARAMS(value) {
     return "'" + value + "'";
}

async function FETCH(url, formData, callback) {
     var response;
     await fetch(url, { method: 'POST', body: formData})
     .then((response) => {
          return response.text();
     })
     .then((body) => {
          console.log(body);
          callback();
          response = body;
     })
     return response;
}

function SPECIAL_CHARS(text) {
     var map = {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#039;'
     };
     return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function RAND_INT(min, max) {
     min = Math.ceil(min);
     max = Math.floor(max);
     return Math.floor(Math.random() * (max - min + 1)) + min;
 }

export { FETCH, GET_PARAMS, SPECIAL_CHARS, RAND_INT };