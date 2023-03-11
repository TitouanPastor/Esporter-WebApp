<?php 

    class ArbitreDAO{
        private $linkpdo;

        public function __construct()
        {
            //Connexion to DB
            require_once('connectDB.php');
            $sql = new connectDB();
            $this->linkpdo = $sql->getConnection();
        }

    //Fonction qui retourne les jeux d'un tournois
    public function getJeuxTournois($id, $choix = "default")
    {
        if ($choix == "libelle") {
            $req = $this->linkpdo->prepare('SELECT jeu.libelle FROM jeu, concerner, tournoi WHERE tournoi.Id_tournoi = concerner.id_tournoi AND jeu.id_jeu = concerner.id_jeu AND concerner.Id_Tournoi = :IdTournoi ');
        } else {
            $req = $this->linkpdo->prepare('SELECT jeu.* FROM jeu, concerner, tournoi where tournoi.Id_Tournoi = concerner.Id_Tournoi and jeu.Id_Jeu = concerner.Id_Jeu and concerner.Id_Tournoi = :IdTournoi');
        }

        $req->execute(array("IdTournoi" => $id));
        return $req;
    }

    public function getTournoiCommence()
    {
        $req = $this->linkpdo->prepare("SELECT nom, date_debut, id_tournoi FROM tournoi where tournoi.date_debut < curdate()");
        $testReq = $req->execute();
        if ($testReq == false) {
            die('Erreur getTournoiCommence');
        }
        return $req;
    }
}
