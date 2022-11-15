
function afficherDescriptionTournoi(obj) {
    // Arrow
    var arrow = obj.querySelector('.arrow');
    console.log(arrow);
    arrow.classList.toggle('arrow-active');

    // 
    var descriptiontournoi = obj.querySelector('.description-tournoi');
    console.log(descriptiontournoi);
    descriptiontournoi.classList.toggle('description-tournoi-active');
}

function changerTabListeTournoi(obj) {
    // Liste
    console.log(obj);
    // var tabclassname = 'liste'+obj.Name;
    // // on enleve la classe active de tous les elements de la liste
    // var listetournoi = document.querySelectorAll('.liste');
    // for (var i = 0; i < listetournoi.length; i++) {
    //     listetournoi[i].classList.remove('liste-tab-active');
    // }

    // var liste = obj.querySelector(tabclassname);
    // console.log(liste.className);
    // liste.classList.add('liste-tab-active');
}