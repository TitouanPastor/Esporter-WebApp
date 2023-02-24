<?php

class connectDB
{
    private $linkpdo;

    public function __construct()
    {

        ///Connexion au serveur MySQL avec PDO
        $server = 'sql849.main-hosting.eu';
        $login  = 'u743447366_admin';
        $mdp    = 'YAksklOw6qN$';
        $db     = 'u743447366_esporter';

        try {
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
            //Utiliser pour le debogage
            $this->linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        ///Capture des erreurs éventuelles
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->linkpdo;
    }

    public function closeConnection()
    {
        $this->linkpdo = null;
    }
}
