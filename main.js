
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