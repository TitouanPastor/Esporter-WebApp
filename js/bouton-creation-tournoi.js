//Script pour ajouter les jeux dans le select caché
//cela permet de récuperer les jeux dans le POST
$(function() {

    $('#chkveg').multiselect({
        includeSelectAllOption: true
    });

    $('#ajouterjeux').click(function() {
        var a = $('#chkveg').val();
        var spaninfojeu = document.getElementById("spaninfojeu");
        var hiddenselect = document.getElementById("hiddenselect");
        var mainsubmit = document.getElementById("submit");
        var submitselectionjeux = document.getElementById("ajouterjeux");
        while (hiddenselect.firstChild) {
            hiddenselect.removeChild(hiddenselect.firstChild);
        }
        if (a.length == 0) {
            spaninfojeu.innerHTML = "Aucun jeu sélectionné";
        } else {
            mainsubmit.classList.add("submit-active");
            mainsubmit.removeAttribute("disabled");
            spaninfojeu.innerHTML = a.length + " jeu(x) enregistré(s) !";
            submitselectionjeux.classList.add("ajouterjeu-valid");
        }
        for (var i = 0; i < a.length; i++) {
            var opt = document.createElement('option');
            opt.value = a[i];
            opt.innerHTML = a[i];
            opt.selected = true;
            hiddenselect.appendChild(opt);
        }
    });
});
