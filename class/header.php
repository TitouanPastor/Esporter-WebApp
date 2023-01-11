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
    private $pathlistetournoiarbitre = "#"; //etage 2
    private $pathaddequipes = "#"; //etage 2
    private $pathlogo = "#"; //etage 1
    private $pathlisteequipeECU = "#"; //etage 2
    private $pathtournoisInscrits = "#"; //etage 2
    private $pathClassementCm = "#"; //etage 2

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
            $this->pathinscription = "pages/equipe/inscription-tournoi.php";
            $this->pathlistetournoiarbitre = "pages/arbitre/liste-tournois-commence.php";
            $this->pathaddequipes = "pages/ecurie/enregistrer-equipe.php";
            $this->pathlogo = "img/esporter-logo.png";
            $this->pathlisteequipeECU = "pages/ecurie/liste-equipes.php";
            $this->pathtournoisInscrits = "pages/equipe/liste-tournois-inscrit.php";
            $this->pathClassementCm = "pages/visiteur/classementCM.php";
        } elseif ($etage == 1) {
            $this->pathindex = "../index.php";
            $this->pathresultats = "visiteur/resultats.php";
            $this->pathcalendrier = "visiteur/calendrier.php";
            $this->pathconnexion = "visiteur/login.php";
            $this->pathaddtournoi = "admin/creation-tournoi.php";
            $this->pathlistetournoi = "admin/liste-tournois.php";
            $this->pathaddecurie = "admin/enregistrer-ecurie.php";
            $this->pathlisteecurie = "admin/liste-ecuries.php";
            $this->pathinscription = "equipe/inscription-tournoi.php";
            $this->pathlistetournoiarbitre = "arbitre/liste-tournois-commence.php";
            $this->pathaddequipes = "ecurie/enregistrer-equipe.php";
            $this->pathlogo = "../img/esporter-logo.png";
            $this->pathlisteequipeECU = "../pages/ecurie/liste-equipes.php";
            $this->pathtournoisInscrits = "equipe/liste-tournois-inscrit.php";
            $this->pathClassementCm = "visiteur/classementCM.php";
        } elseif ($etage == 2) {
            $this->pathindex = "../../index.php";
            $this->pathresultats = "../visiteur/resultats.php";
            $this->pathcalendrier = "../visiteur/calendrier.php";
            $this->pathconnexion = "../visiteur/login.php";
            $this->pathaddtournoi = "../admin/creation-tournoi.php";
            $this->pathlistetournoi = "../admin/liste-tournois.php";
            $this->pathaddecurie = "../admin/enregistrer-ecurie.php";
            $this->pathlisteecurie = "../admin/liste-ecuries.php";
            $this->pathinscription = "../equipe/inscription-tournoi.php";
            $this->pathlistetournoiarbitre = "../arbitre/liste-tournois-commence.php";
            $this->pathaddequipes = "../ecurie/enregistrer-equipe.php";
            $this->pathlogo = "../../img/esporter-logo.png";
            $this->pathlisteequipeECU = "../ecurie/liste-equipes.php";
            $this->pathtournoisInscrits = "../equipe/liste-tournois-inscrit.php";
            $this->pathClassementCm = "../visiteur/classementCM.php";
        }

        echo '
            <header>
            <div class="topnavbar">
            <a class="header-logo-link" href="' . $this->pathindex . '">
                <img src="' . $this->pathlogo . '" alt="" class="navbar-logo">
            </a>
                <ul class="navbar-menu">
                    <li class="navbar-item"><a href="' . $this->pathindex . '" class="navbar-link">Accueil</a></li>
                    <li class="navbar-item"><a href="#" class="navbar-link">Leaderboards</a>
                    <ul class="sousmenu">
                        <li class="navbar-item"><a href="' . $this->pathresultats . '" class="navbar-link">Classement</a></li>
                        <li class="navbar-item"><a href="' . $this->pathClassementCm . '" class="navbar-link">Résultats</a></li>
                    </ul>
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
        } elseif ($role == "equipe") {
            return $this->header_equipe();
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
            <li class="navbar-item"><a href="' .$this->pathlisteequipeECU . '" class="navbar-link">Equipes</a></li>
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
        <li class="navbar-item"><a href="#" class="navbar-link">Tournois</a>
        <ul class="sousmenu">
            <li class="navbar-item"><a href="' . $this->pathinscription . '" class="navbar-link">S\'inscrire</a>
            <li class="navbar-item"><a href="' . $this->pathtournoisInscrits . '" class="navbar-link">Mes tournois</a>
        </ul>
        </li>
        <li class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }

    public function header_arbitre()
    {
        return '
        <li class="navbar-item"><a href="#" class="navbar-link">Arbitre</a>
        <ul class="sousmenu">
            <li class="navbar-item"><a href="' . $this->pathlistetournoiarbitre . '" class="navbar-link">Liste Tournoi</a>
        </ul>
        </li>
        <li class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }
}
