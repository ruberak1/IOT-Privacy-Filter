function getCookie(name) {
    var cookieName = name + "="
    var docCookie = document.cookie
    var cookieStart
    var end
 
    if (docCookie.length>0) {
       cookieStart = docCookie.indexOf(cookieName)
       if (cookieStart != -1) {
          cookieStart = cookieStart + cookieName.length
          end = docCookie.indexOf(";",cookieStart)
          if (end == -1) {
             end = docCookie.length
          }
          return unescape(docCookie.substring(cookieStart,end))
       }
    }
    return false
 }
//let loadUsername = document.getElementById('loginForm').elements['unameInput'];
//let loadPassword = document.getElementById('loginForm').elements['passInput'];
//let username = loadUsername.value;
//let password = loadPassword.value;
//document.getElementById('urlInsert').innerHTML = "<meta http-equiv='refresh' content='5; URL=https://" + username + ":" + password + "@privacyfence.tk/profiles/" + username + " / >";

let username = getCookie('username');
let password = getCookie('password');
let urlInsert = "https://" + username + ":" + password + "@privacyfence.tk/profiles/" + username + "/device.php";

//redirect to user profile
window.location.replace(urlInsert);
