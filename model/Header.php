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

    public function __construct()
    {
        $nomPage = explode("/", $_SERVER["PHP_SELF"]);
        $nomPage = $nomPage[count($nomPage) - 1];
        if ($nomPage == "index.php") {
            $this->pathindex = "#";
            $this->pathresultats = "controller/visiteur/liste-tournois-commence-controller.php";
            $this->pathcalendrier = "controller/visiteur/calendrier-controller.php";
            $this->pathconnexion = "controller/visiteur/login-controller.php";
            $this->pathaddtournoi = "controller/admin/creation-tournoi-controller.php";
            $this->pathlistetournoi = "controller/admin/liste-tournois-controller.php";
            $this->pathaddecurie = "controller/admin/enregistrer-ecurie-controller.php";
            $this->pathlisteecurie = "controller/admin/liste-ecurie-controller.php";
            $this->pathinscription = "controller/equipe/inscription-tournoi-controller.php";
            $this->pathlistetournoiarbitre = "controller/arbitre/liste-tournois-commence-controller.php";
            $this->pathaddequipes = "controller/ecurie/enregistrer-equipe-controller.php";
            $this->pathlogo = "img/esporter-logo.png";
            $this->pathlisteequipeECU = "controller/ecurie/liste-equipes-controller.php";
            $this->pathtournoisInscrits = "controller/equipe/liste-tournois-inscrit-controller.php";
            $this->pathClassementCm = "controller/visiteur/classementCM-controller.php";
        } else {
            $this->pathindex = "../../index.php";
            $this->pathresultats = "../visiteur/liste-tournois-commence-controller.php";
            $this->pathcalendrier = "../visiteur/calendrier-controller.php";
            $this->pathconnexion = "../visiteur/login-controller.php";
            $this->pathaddtournoi = "../admin/creation-tournoi-controller.php";
            $this->pathlistetournoi = "../admin/liste-tournois-controller.php";
            $this->pathaddecurie = "../admin/enregistrer-ecurie-controller.php";
            $this->pathlisteecurie = "../admin/liste-ecuries-controller.php";
            $this->pathinscription = "../equipe/inscription-tournoi-controller.php";
            $this->pathlistetournoiarbitre = "../arbitre/liste-tournois-commence-controller.php";
            $this->pathaddequipes = "../ecurie/enregistrer-equipe-controller.php";
            $this->pathlogo = "../../img/esporter-logo.png";
            $this->pathlisteequipeECU = "../ecurie/liste-equipes-controller.php";
            $this->pathtournoisInscrits = "../equipe/liste-tournois-inscrit-controller.php";
            $this->pathClassementCm = "../visiteur/classementCM-controller.php";
        }



        echo '
            <header>
            <div class="topnavbar">
            <a class="header-logo-link" href="' . $this->pathindex . '">
                <img src="' . $this->pathlogo . '" alt="Logo de l\'application E-Sporter" class="navbar-logo">
            </a>
                <ul class="navbar-menu">
                    <li class="navbar-item"><a href="' . $this->pathindex . '" class="navbar-link">Accueil</a></li>
                    <li class="navbar-item"><a href="' . $this->pathClassementCm . '" class="navbar-link">Classement</a></li>
                    <li class="navbar-item"><a href="' . $this->pathresultats . '" class="navbar-link">Résultats</a></li>
                    <li class="navbar-item"><a href="' . $this->pathcalendrier . '" class="navbar-link">Calendrier</a></li>
        ';
    }

    public function customizeHeader($role = "visiteur")
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

    public function headerLogin()
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
        <li class="navbar-item connected-name-container">
            <span class="navbar-link">' . ucfirst($_SESSION['role']) . ' : ' . strtok($_SESSION['username'], '@') . ' </span>
            <div class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></div>
        </li>
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
            <li class="navbar-item"><a href="' . $this->pathlisteequipeECU . '" class="navbar-link">Equipes</a></li>
        </ul>
        </li>
        <li class="navbar-item connected-name-container">
            <span class="navbar-link">' . ucfirst($_SESSION['role']) . ' : ' . strtok($_SESSION['username'], '@') . ' </span>
            <div class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></div>
        </li>
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
        <li class="navbar-item connected-name-container">
            <span class="navbar-link">' . ucfirst($_SESSION['role']) . ' : ' . strtok($_SESSION['username'], '@') . ' </span>
            <div class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></div>
        </li>
    </ul>
</div>
</header>';
    }

    public function header_arbitre()
    {
        return '
        <li class="navbar-item"><a href="' . $this->pathlistetournoiarbitre . '" class="navbar-link">Rentrer résultats</a></li>
        <li class="navbar-item connected-name-container">
            <span class="navbar-link">' . ucfirst($_SESSION['role']) . ' : ' . strtok($_SESSION['username'], '@') . ' </span>
            <div class="navbar-item"><a href="' . $this->pathconnexion . '" class="btn-connexion">Déconnexion</a></div>
        </li>
    </ul>
</div>
</header>';
    }
}
