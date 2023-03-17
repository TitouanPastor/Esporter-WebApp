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
        } elseif ($choix == "id") {
            $req = $this->linkpdo->prepare('SELECT jeu.Id_Jeu, jeu.libelle FROM jeu, concerner, tournoi WHERE tournoi.Id_tournoi = concerner.id_tournoi AND jeu.id_jeu = concerner.id_jeu AND concerner.Id_Tournoi = :IdTournoi ');
        } else {
            $req = $this->linkpdo->prepare('SELECT jeu.* FROM jeu, concerner, tournoi where tournoi.Id_Tournoi = concerner.Id_Tournoi and jeu.Id_Jeu = concerner.Id_Jeu and concerner.Id_Tournoi = :IdTournoi');
        }

        $req->execute(array("IdTournoi" => $id));
        return $req;
    }

    public function getTournoiCommence()
    {
        $req = $this->linkpdo->prepare("SELECT t.nom, t.Date_debut, t.Id_Tournoi,count(etre_inscrit.id_Tournoi) FROM tournoi as t, etre_inscrit where t.Date_debut < curdate() and etre_inscrit.id_Tournoi = t.Id_Tournoi and t.estFerme = 1 group by etre_inscrit.Id_Tournoi, etre_inscrit.id_Jeu having count(etre_inscrit.Id_Tournoi )>= 16;");
        $testReq = $req->execute();
        if ($testReq == false) {
            die('Erreur getTournoiCommence');
        }
        return $req;
    }
}
