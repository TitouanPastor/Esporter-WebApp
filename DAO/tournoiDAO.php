<?php 

    class TournoiDAO
    {

        private $linkpdo;

        public function __construct()
        {
            //Connexion to DB
            require_once('connectDB.php');
            $sql = new connectDB();
            $this->linkpdo = $sql->getConnection();
        }
    }
?>