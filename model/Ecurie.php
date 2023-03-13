<?php
class Ecurie
{
    private $dao;

    public function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/EcurieDAO.php'));
        $this->dao = new EcurieDAO();
    }

    public function trierPar(string $by)
    {
        require_once('tri-ecuries.php');
        $triEcuries = new TriEcuries();
        switch ($by) {
            case 'nom':
                return $triEcuries->trierParNom();
                break;
            case 'statut':
                return $triEcuries->trierParStatut();
                break;
            default:
                return $triEcuries->trierParId();
                break;
        }
        return "Erreur de tri";
    }

    public function getEcurie()
    {
        return $this->dao->getEcurie();
    }

    public function addEcurie($nom, $statut, $mdp, $mail, $idGestionnaire)
    {
        $this->dao->addEcurie($nom, $statut, $mdp, $mail, $idGestionnaire);
    }

    public function getIdEcurieByMail($mail)
    {
        return $this->dao->getIdEcurieByMail($mail);
    }

    public function getEquipeEcurie($id)
    {
        return $this->dao->getEquipeEcurie($id);
    }

    public function getJeuByIdEquipe($idEquipe)
    {
        return $this->dao->getJeuByIdEquipe($idEquipe);
    }

    public function getJoueurByIdEquipe($id)
    {
        return $this->dao->getJoueurByIdEquipe($id);
    }

    public function equipeByPoint($idEcurie)
    {
        return $this->dao->equipeByPoint($idEcurie);
    }

    public function equipeByNom($idEcurie)
    {
        return $this->dao->equipeByNom($idEcurie);
    }
    public function getEquipeByIdEcurie($id)
    {
        return $this->dao->getEquipeByIdEcurie($id);
    }

    public function ecuriesByNom()
    {
        return $this->dao->ecuriesByNom();
    }

    public function ecuriesByStatut()
    {
        return $this->dao->ecuriesByStatut();
    }
}
