
// Fonction qui notifie l'utilisateur que le tournoi a bien été fermé et qui s'affiche sous la forme d'une notification
function notifyTournoi() {
    var notification = document.querySelector('.notification');
    notification.classList.add('notification-active');
    setTimeout(function () {
        notification.classList.remove('notification-active');
    }, 5000);
}
// Fonction qui cherche lorsque la page est chargée si il y a un paramètre ?param dans l'url
window.onload = function () {
    var url = window.location.href;
    if (url.indexOf('?close_id') != -1) {
        var texteNotif = document.querySelector('.notification-body p');
        texteNotif.innerHTML = "Le tournoi a bien été fermé.";
        // On change l'url de la page en enlevant le variable ?close_id
        window.history.pushState("", "", "liste-tournois-controller.php");
        notifyTournoi();
    } else if (url.indexOf('?modifyTournoi') != -1) {
        var texteNotif = document.querySelector('.notification-body p');
        texteNotif.innerHTML = "Le tournoi a bien été modifié.";
        window.history.pushState("", "", "liste-tournois-controller.php");
        notifyTournoi();
    } else if (url.indexOf('?createTournoi') != -1) {
        var texteNotif = document.querySelector('.notification-body p');
        texteNotif.innerHTML = "Le tournoi a bien été créé.";
        window.history.pushState("", "", "liste-tournois-controller.php");
        notifyTournoi();
    }
}