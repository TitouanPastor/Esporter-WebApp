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
        ';
        }

        public function header_visiteur(){
            echo '              <li><a href="#">Accueil</a></li>
                                <li><a href="#">Résultat</a></li>
                                <li><a href="#">Calendrier</a></li> 
                            </ul>
                        </article>
                    </section>
                </header>';
        }

        

    }


?>