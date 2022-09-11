// import axios from '../../node_modules/axios/dist/axios.js';

const serverEndPoint = 'http://localhost:8000';
function getCookie(name) {
    var cookieArr = document.cookie.split(";");
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        if(name == cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}
function setCookie(name, value) {
    document.cookie = `${name}=${encodeURIComponent(value)}`;
}