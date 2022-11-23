<?php
class Header
{

    private $pathindex = "#"; //etage 0
    private $pathresultats = "#"; //etage 1
    private $pathcalendrier = "#"; //etage 1
    private $pathconnexion = "#"; //etage 1
    private $pathaddtournoi = "#"; //etage 2
    private $pathlistetournoi = "#"; //etage 2
    private $pathaddecurie = "#"; //etage 2
    private $pathlisteecurie = "#"; //etage 2
    private $pathinscription = "#"; //etage 2
    private $pathtournoisarbitre = "#"; //etage 2
    private $pathaddequipes = "#"; //etage 2
    private $pathlogo = "#"; //etage 1

    public function __construct($etage)
    {
        if ($etage == 0) {
            $this->pathindex = "index.php";
            $this->pathresultats = "pages/visiteur/resultats.php";
            $this->pathcalendrier = "pages/visiteur/calendrier.php";
            $this->pathconnexion = "pages/visiteur/login.php";
            $this->pathaddtournoi = "pages/admin/creation-tournoi.php";
            $this->pathlistetournoi = "pages/admin/liste-tournois.php";
            $this->pathaddecurie = "pages/admin/enregistrer-ecurie.php";
            $this->pathlisteecurie = "pages/admin/liste-ecuries.php";
            $this->pathinscription = "pages/admin/inscription.php";
            $this->pathtournoisarbitre = "pages/admin/tournoisarbitre.php";
            $this->pathaddequipes = "pages/admin/enregistrer-equipe.php";
            $this->pathlogo = "img/esporter-logo.png";
        } elseif ($etage == 1) {
            $this->pathindex = "../index.php";
            $this->pathresultats = "visiteur/resultats.php";
            $this->pathcalendrier = "visiteur/calendrier.php";
            $this->pathconnexion = "visiteur/login.php";
            $this->pathaddtournoi = "admin/creation-tournoi.php";
            $this->pathlistetournoi = "admin/liste-tournois.php";
            $this->pathaddecurie = "admin/enregistrer-ecurie.php";
            $this->pathlisteecurie = "admin/liste-ecuries.php";
            $this->pathinscription = "admin/inscription.php";
            $this->pathtournoisarbitre = "admin/tournoisarbitre.php";
            $this->pathaddequipes = "admin/enregistrer-equipe.php";
            $this->pathlogo = "../img/esporter-logo.png";
        } elseif ($etage == 2) {
            $this->pathindex = "../../index.php";
            $this->pathresultats = "../visiteur/resultats.php";
            $this->pathcalendrier = "../visiteur/calendrier.php";
            $this->pathconnexion = "../visiteur/login.php";
            $this->pathaddtournoi = "../admin/creation-tournoi.php";
            $this->pathlistetournoi = "../admin/liste-tournois.php";
            $this->pathaddecurie = "../admin/enregistrer-ecurie.php";
            $this->pathlisteecurie = "../admin/liste-ecuries.php";
            $this->pathinscription = "../admin/inscription.php";
            $this->pathtournoisarbitre = "../admin/tournoisarbitre.php";
            $this->pathaddequipes = "../admin/enregistrer-equipe.php";
            $this->pathlogo = "../../img/esporter-logo.png";
        }

        echo '
            <header>
            <div class="topnavbar">
            <a class="header-logo-link" href="' . $this->pathindex . '">
                <img src="' . $this->pathlogo . '" alt="" class="navbar-logo">
            </a>
                <ul class="navbar-menu">
                    <li class="navbar-item"><a href="' . $this->pathindex . '" class="navbar-link">Accueil</a></li>
                    <li class="navbar-item"><a href="' . $this->pathresultats . '" class="navbar-link">Résultats</a></li>
                    <li class="navbar-item"><a href="' . $this->pathcalendrier . '" class="navbar-link">Calendrier</a></li>
        ';
    }

    public function customize_header($role = "visiteur")
    {
        if ($role == "arbitre") {
            return $this->header_arbitre();
            echo "arbitre";
        } elseif ($role == "ecurie") {
            return $this->header_ecurie();
            echo "ecurie";
        } elseif ($role == "gestionnaire") {
            return $this->header_admin();
            echo "admin";
        } else {
            return $this->header_visiteur();
            echo "visiteur";
        }
    }

    public function header_login()
    {
        return '
        </ul>
    </div>
</header>';
    }

    public function header_visiteur()
    {
        return '
            <li class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Connexion</a></li>
            </ul>
        </div>
    </header>';
    }

    public function header_admin()
    {
        return '
        <li class="navbar-item"><a href="#" class="navbar-link">Administration</a>
        <ul class="sousmenu">
            <li class="navbar-item"><a href="' . $this->pathaddtournoi . '" class="navbar-link">Ajouter un tournoi</a></li>
            <li class="navbar-item"><a href="' . $this->pathlistetournoi . '" class="navbar-link">Tournois</a></li>
            <li class="navbar-item"><a href="' . $this->pathaddecurie . '" class="navbar-link">Ajouter une écurie</a></li>
            <li class="navbar-item"><a href="' . $this->pathlisteecurie . '" class="navbar-link">Ecuries</a></li>
        </ul>
        </li>
        <li class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }

    public function header_ecurie()
    {
        return '
        <li class="navbar-item"><a href="#" class="navbar-link">Ecurie</a>
        <ul class="sousmenu">
            <li class="navbar-item"><a href="' . $this->pathaddequipes . '" class="navbar-link">Ajouter une équipe</a></li>
            <li class="navbar-item"><a href="#" class="navbar-link">Equipes</a></li>
        </ul>
        </li>
        <li class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }

    public function header_equipe()
    {
        return '
        <li class="navbar-item"><a href="' . $this->pathinscription . '" class="navbar-link">Inscription</a>
        </li>
        <li class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }

    public function header_arbitre()
    {
        return '
        <li class="navbar-item"><a href="' . $this->pathtournoisarbitre . '" class="navbar-link">Tournois</a>
        </li>
        <li class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }
}
