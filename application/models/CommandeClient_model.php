<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ceci est le modele pour le commande côté client
 */
class CommandeClient_model extends CI_Model
{
	protected $ligneCom = 'lignecomcli';
	protected $commande = 'commande_cli';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Produit_model' , 'Prod');
	}
	public function insertCommande($codeCli , $codepro , $qte)
	{
			for($i = 0 ; $i < count($codepro) ; $i++)
			{
				$sql = "INSERT into lignecomcli values(NULL , ? , ?)";
				$sql2 = "INSERT into commande_cli values(NULL , NOW() , ?)";
				
				$this->Prod->commande($codepro[$i] , $qte[$i]);
				$this->db->query($sql , array($codepro[$i] , $qte[$i]));
				$this->db->query($sql2 , array($codeCli));
			}
		return true;
	}
	public function genererFacture($row = '')
	{
		if(empty($row))
		{
			$sql = "SELECT nomCli ,adresse , design , lignecomcli.numcomcli AS numfact, qteCom , PU , sum(qteCom * PU) AS total , date_Com AS dates from lignecomcli , produit , client , commande_cli where lignecomcli.numcomcli = commande_cli.numcomcli AND produit.codePro = lignecomcli.codepro AND client.codeCli = commande_cli.codeCli group by lignecomcli.numcomcli order by date_Com desc LIMIT 10";
		$facture = $this->db->query($sql);
		}

		else{
		$sql = "SELECT nomCli , design ,adresse , lignecomcli.numcomcli AS numfact, qteCom , PU , sum(qteCom * PU) AS total , date_Com AS dates from lignecomcli , produit , client , commande_cli where lignecomcli.numcomcli = commande_cli.numcomcli AND produit.codePro = lignecomcli.codepro AND client.codeCli = commande_cli.codeCli group by lignecomcli.numcomcli order by date_Com desc limit ?";
		$facture = $this->db->query($sql , array($row));
		}
		return $facture->result();
	}
	

 
}