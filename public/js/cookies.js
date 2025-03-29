
class COOKIES {

  GET_COOKIE(name) {
    var decodedCookie = decodeURIComponent(document.cookie);
    var parts = decodedCookie.split(';');
    for (var i = 0; i < parts.length; i++) {
      var [key, value] = parts[i].split('=');
      return key === name ? value : null;
    }
  }
}
