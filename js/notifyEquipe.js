// Fonction qui notifie l'utilisateur que le tournoi a bien été fermé et qui s'affiche sous la forme d'une notification
function notifyEquipe() {
    var notification = document.querySelector('.notification');
    notification.classList.add('notification-active');
    setTimeout(function () {
        notification.classList.remove('notification-active');
    }, 5000);
}
// Fonction qui cherche lorsque la page est chargée si il y a un paramètre ?param dans l'url
window.onload = function () {
    var url = window.location.href;
    if (url.indexOf('?createEquipe') != -1) {
        var texteNotif = document.querySelector('.notification-body p');
        texteNotif.innerHTML = "L'équipe à bien été ajoutée.";
        // On change l'url de la page en enlevant le variable ?close_id
        window.history.pushState("", "", "liste-equipes-controller.php");
        notifyEquipe();
    }
}