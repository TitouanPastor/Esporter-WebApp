<?php

use PHPUnit\Framework\TestCase;

final class TestAjouterTournoi extends TestCase
{
    public function testAjoutTournoi()
    {
        require_once(realpath(dirname(__FILE__) . '/../SQL.php'));
        $sql = new requeteSQL();
        $type = 'Local';
        $nom = 'Tournoi de test';
        $date_debut = '2023-05-01';
        $date_fin = '2023-05-05';
        $lieu = 'test';
        $pts = 150;
        $id = 1;
        $sql->addTournoi($type, $nom, $date_debut, $date_fin, $lieu, $pts, $id, $id);
        $idTournoi = $sql->getLastIDTournoi();
        $req = $sql->tournoiId($idTournoi);
        while($row = $req->fetch()){
            $this->assertEquals($row['Nom'], $nom);
            $this->assertEquals($row['Type'], $type);
            $this->assertEquals($row['Date_debut'], $date_debut);
            $this->assertEquals($row['Date_fin'], $date_fin);
            $this->assertEquals($row['Lieu'], $lieu);
            $this->assertEquals($row['Nombre_point_max'], $pts);
        }
    }

    public function testAjouterJeu()
    {
        require_once(realpath(dirname(__FILE__) . '/../SQL.php'));
        $sql = new requeteSQL();
        $libelle = 'God of War';
        $sql->addJeu($libelle);
        $idJeu = $sql->getLastIDJeu();
        $req = $sql->jeuId($idJeu);
        while($row = $req->fetch()){
            $this->assertEquals($row['Libelle'], $libelle);
        }
    }

    public function testConcerner()
    {
        require_once(realpath(dirname(__FILE__) . '/../SQL.php'));
        $sql = new requeteSQL();
        $idTournoi = $sql->getLastIDTournoi();
        $idJeu = $sql->getLastIDJeu();
        $sql->addConcerner($idTournoi,$idJeu);
        $libelle = 'Fortnite';
        $sql->addJeu($libelle);
        $idJeu2 = $sql->getLastIDJeu();
        $sql->addConcerner($idTournoi,$idJeu2);
        $req = $sql->concernerId($idTournoi);
        while($row = $req->fetch()){
            $this->assertEquals($row['Id_Tournoi'], $idTournoi);
            $this->assertEquals($row['Id_Jeu'], $idJeu);
            $this->assertEquals($row['Id_Tournoi'], $idTournoi);
            $this->assertEquals($row['Id_Jeu'], $idJeu2);
        }
    }

}
