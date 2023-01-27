
function afficherDescriptionTournoi(obj) {

    // On récupère l'élément parent de l'élément cliqué
    var parent = null;
    if (obj.className == "arrow") {
        parent = obj.parentNode;
    } else {
        parent = obj.parentNode.parentNode;
    }


    // Arrow
    var arrow = parent.querySelector('.arrow');
    arrow.classList.toggle('arrow-active');

    // Description
    var descriptionTournoi = parent.querySelector('.description-tournoi');
    descriptionTournoi.classList.toggle('description-tournoi-active');
}

function changerTabListe(obj, tabId) {

    // on enleve la classe active de tous les elements de la liste
    var listeTournoi = document.querySelectorAll('.liste');
    for (var i = 0; i < listeTournoi.length; i++) {
        listeTournoi[i].style.display = "none";
    }
    // on enleve la classe btn-filter-active de tous les elements de la liste
    var btnFilter = document.querySelectorAll('.btn-filter-active');
    for (var i = 0; i < btnFilter.length; i++) {
        btnFilter[i].classList.remove('btn-filter-active');
    }

    var liste = document.getElementById(tabId);
    liste.style.display = "flex";

    obj.classList.add('btn-filter-active');
}