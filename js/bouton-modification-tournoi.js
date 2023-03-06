// on load function
window.onload = function () {

    $('#chkveg').multiselect({
        includeSelectAllOption: true
    });

    var a = $('#chkveg').val();
    var hiddenselect = document.getElementById("hiddenselect");
    for (var i = 0; i < a.length; i++) {
        var opt = document.createElement('option');
        opt.value = a[i];
        opt.innerHTML = a[i];
        opt.selected = true;
        hiddenselect.appendChild(opt);
    }
}

//Script pour ajouter les jeux dans le select caché
//cela permet de récuperer les jeux dans le POST
$(function () {

    $('#chkveg').multiselect({
        includeSelectAllOption: true
    });

    $('#ajouterjeux').click(function () {
        var a = $('#chkveg').val();
        var spaninfojeu = document.getElementById("spaninfojeu");
        var hiddenselect = document.getElementById("hiddenselect");
        var mainsubmit = document.getElementById("submit");
        var submitselectionjeux = document.getElementById("ajouterjeux");
        while (hiddenselect.firstChild) {
            hiddenselect.removeChild(hiddenselect.firstChild);
        }
        for (var i = 0; i < a.length; i++) {
            var opt = document.createElement('option');
            opt.value = a[i];
            opt.innerHTML = a[i];
            opt.selected = true;
            hiddenselect.appendChild(opt);
        }
        console.log(a.length)
        if (a.length == 0) {

            spaninfojeu.innerHTML = "Aucun jeu sélectionné";
        } else {
            spaninfojeu.innerHTML = a.length + " jeu(x) enregistré(s) !";
        }
    });
});