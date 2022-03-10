'use strict'


if(document.querySelector('#eye') !== null) {
    const eye = document.querySelector('#eye');
    eye.addEventListener('click', viewPassword);
}

if(document.querySelector('#password') !== null) {
    const password = document.querySelector('#password');
}

function viewPassword() {
    if(password.type =='password'){
        password.setAttribute('type', 'text');
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
        eye.setAttribute('style', 'color: #9FC5E2');
    }
    else {
        password.setAttribute('type', 'password');
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
        eye.setAttribute('style', 'color: black');
    }
    window.setTimeout(hidePassword, 10000);
}

function hidePassword() {
    password.setAttribute('type', 'password');
    eye.classList.remove('fa-eye');
    eye.classList.add('fa-eye-slash');
    eye.setAttribute('style', 'color: black');
}



function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}








