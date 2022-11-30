
function afficherDescriptionTournoi(obj) {

    var parent = null;
    if (obj.className == "arrow") {
        parent = obj.parentNode;
    } else {
        parent = obj.parentNode.parentNode;
    }


    // Arrow
    var arrow = parent.querySelector('.arrow');
    arrow.classList.toggle('arrow-active');

    // 
    var descriptiontournoi = parent.querySelector('.description-tournoi');
    descriptiontournoi.classList.toggle('description-tournoi-active');
}

function changerTabListe(obj, tabId) {

    // on enleve la classe active de tous les elements de la liste
    var listetournoi = document.querySelectorAll('.liste');
    for (var i = 0; i < listetournoi.length; i++) {
        listetournoi[i].style.display = "none";
    }
    // on enleve la classe btn-filter-active de tous les elements de la liste
    var btnfilter = document.querySelectorAll('.btn-filter-active');
    for (var i = 0; i < btnfilter.length; i++) {
        btnfilter[i].classList.remove('btn-filter-active');
    }

    var liste = document.getElementById(tabId);
    liste.style.display = "flex";

    obj.classList.add('btn-filter-active');
}