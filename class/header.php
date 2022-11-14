<?php
class Header
{

    public function __construct()
    {
        echo '
            <header>
            <div class="topnavbar">
                <img src="img/logoesporter.jpg" alt="" class="navbar-logo">
                <ul class="navbar-menu">
                    <li class="navbar-item"><a href="../../index.php" class="navbar-link">Accueil</a></li>
                    <li class="navbar-item"><a href="#" class="navbar-link">Résultats</a></li>
                    <li class="navbar-item"><a href="#" class="navbar-link">Calendrier</a></li>
        ';
    }

    public function header_visiteur()
    {
        return '
            <li class="navbar-item"><a href="#" class="btn-connexion">Connexion</a></li>
            </ul>
        </div>
    </header>';
    }

    public function header_admin()
    {
        return '
        <li class="navbar-item"><a href="#" class="navbar-link">Administration</a>
        <ul class="sousmenu">
            <li class="navbar-item"><a href="#" class="navbar-link">Ajouter un tournoi</a></li>
            <li class="navbar-item"><a href="#" class="navbar-link">Tournois</a></li>
            <li class="navbar-item"><a href="#" class="navbar-link">Ajouter une écurie</a></li>
            <li class="navbar-item"><a href="#" class="navbar-link">Ecuries</a></li>
        </ul>
        </li>
        <li class="navbar-item"><a href="#" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }

    public function header_ecurie()
    {
        return '
        <li class="navbar-item"><a href="#" class="navbar-link">Ecurie</a>
        <ul class="sousmenu">
            <li class="navbar-item"><a href="#" class="navbar-link">Ajouter une équipe</a></li>
            <li class="navbar-item"><a href="#" class="navbar-link">Equipes</a></li>
        </ul>
        </li>
        <li class="navbar-item"><a href="#" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }

    public function header_equipe()
    {
        return '
        <li class="navbar-item"><a href="#" class="navbar-link">Inscription</a>
        </li>
        <li class="navbar-item"><a href="#" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }

    public function header_arbitre()
    {
        return '
        <li class="navbar-item"><a href="#" class="navbar-link">Tournois</a>
        </li>
        <li class="navbar-item"><a href="#" class="btn-connexion">Déconnexion</a></li>
    </ul>
</div>
</header>';
    }
}
