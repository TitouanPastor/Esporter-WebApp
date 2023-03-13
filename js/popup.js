function openPopUp(a) {
    document.querySelector('.popupconfirm').style.display = 'flex';
    document.querySelector('.idTournoi').innerHTML = a.getAttribute('value');
}

function popupYes() {
    document.querySelector('.popupconfirm').style.display = 'none';
    window.location.href = document.querySelector('.idTournoi').innerHTML;
}

function popupNo() {
    document.querySelector('.popupconfirm').style.display = 'none';
}