<?php
    class Header{
        public function __construct(){
            echo '
            <header>
            <section class="first_section">
                <article class="logo">
                    <img class="banner" src="https://cdn.discordapp.com/attachments/1016239276884754482/1035551785802281051/unknown.png" alt="logo">
                </article>
                <article class="title">
                    <h1>E-Sporter</h1>
                </article>
                <article class="connexion">
                    <a class="button" href="#">Se connecter</a>
                </article>
            </section>
            <section class="second_section">
                <article class="menu">
                    <ul>
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Résultat</a></li>
                        <li><a href="#">Calendrier</a></li> 
        ';
        }

        public function header_visiteur(){
            return '              <li><a href="#">Accueil</a></li>
                                <li><a href="#">Résultat</a></li>
                                <li><a href="#">Calendrier</a></li> 
                            </ul>
                        </article>
                    </section>
                </header>';
        }

        public function header_admin(){
            return '
            <li class="menu-deroulant">
                <a href="#">Adminisatrateur</a>
                     <ul class="sous-menu">
                                <li><a href="#">Ajouter un tournoi</a></li>
                                <li><a href="#">Tournois</a></li>
                                <li><a href="#">Ajouter une écurie</a></li>
                                <li><a href="#">Ecuries</a></li>
                            </ul>
                        </li>
                     </ul>
                </article>
            </section>
        </header>';
        }

        public function header_ecurie(){
            return '
            <li class="menu-deroulant">
                <a href="#">Ecurie</a>
                     <ul class="sous-menu">
                                <li><a href="#">Ajouter une équipe</a></li>
                                <li><a href="#">Equipes</a></li>
                            </ul>
                        </li>
                     </ul>
                </article>
            </section>
        </header>';
        }

        public function header_equipe(){
            return '
            <li>
                <a href="#">Inscription</a></li>
                </article>
            </section>
        </header>';
        }

        public function header_arbitre(){
            return '
            <li>
                <a href="#">Tournois</a></li>
                </article>
            </section>
        </header>';
        }


    }


?>