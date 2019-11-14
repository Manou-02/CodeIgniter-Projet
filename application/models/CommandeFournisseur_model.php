<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ceci est le modele pour le commande côté fournisseur
 */
class CommandeFournisseur_model extends CI_Model
{
	protected $ligneCom = 'lignecomfrs';
	protected $commande = 'commandefrs';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Produit_model' , 'Prod');
	}
	public function insertCommande($codeFrs , $codepro , $qte)
	{

			for($i = 0 ; $i < count($codepro) ; $i++)
			{
				$sql = "INSERT into lignecomfrs values(NULL , ? , ?)";
				
				$sql2 = "INSERT into commandefrs values(NULL , NOW() , ?)";
				
				$this->Prod->approvisionnement($codepro[$i] , $qte[$i]);
				
				$this->db->query($sql , array($codepro[$i] , $qte[$i]));
				
				$this->db->query($sql2 , array($codeFrs));
			}
			return true;
	}
	public function genererFacture($row = '')
	{
		if(empty($row))
		{
			$sql = "SELECT nomFrs , design , lignecomfrs.numcomfrs AS numfact, qteAppro , PU , sum(qteAppro * PU) AS total , date_Com AS dates from lignecomfrs , produit , fournisseur , commandefrs where lignecomfrs.numcomfrs = commandefrs.numcomfrs AND produit.codePro = lignecomfrs.codepro AND fournisseur.codeFrs = commandefrs.codeFrs group by lignecomfrs.numcomfrs order by dates desc LIMIT 10";
		
				$facture = $this->db->query($sql);
		}
		else{
		$sql = "SELECT nomFrs , design , lignecomfrs.numcomfrs AS numfact, qteCom , PU , sum(qteCom * PU) AS total , date_Com AS dates from lignecomfrs , produit , fournisseur , commandefrs where lignecomfrs.numcomfrs = commandefrs.numcomfrs AND produit.codePro = lignecomfrs.codepro AND fournisseur.codeFrs = commandefrs.codeFrs group by lignecomfrs.numcomfrs order by date_Com desc limit ?";
		$facture = $this->db->query($sql , array($row));
		}
		return $facture->result();
	}

}