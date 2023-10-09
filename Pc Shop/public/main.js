function myFunction(x) {
    x.classList.toggle("change");
    var menu = document.getElementById('menu-box-smaller');
    var display = menu.style.display;

    if (display == 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
}

function myFunctionSec(x) {
    x.classList.toggle("change");
    var menu = document.getElementById('menu-box-smallest');
    var display = menu.style.display;

    if (display == 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
}

function checkboxChange() {
    var chb = document.getElementById('confirmation');
    if (chb.checked) {
        document.getElementById('btn-reg-confirm').style.color = 'white';
        document.getElementById('btn-reg-confirm').style.backgroundColor = '#005DA4';
        document.getElementById('btn-reg-confirm').disabled = false;
    } else {
        document.getElementById('btn-reg-confirm').style.color = ' #005DA4';
        document.getElementById('btn-reg-confirm').style.backgroundColor = 'white';
        document.getElementById('btn-reg-confirm').disabled = true;
    }
}