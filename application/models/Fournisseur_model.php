<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Fournisseur_model extends CI_Model
{
	protected $fournisseur = 'fournisseur';
	public function __construct()
	{
		parent::__construct();
	}
	public function getCountFournisseur()
	{
	return $this->db->count_all_results($this->fournisseur);
	}
	public function getfournisseurDescription($codeFrs)
	{
		$sql = "SELECT codeFrs , nomFrs , adresse from fournisseur where codeFrs = ?";
		$result = $this->db->query($sql , array($codeFrs));

		return $result->result();
	}
	public function update($codeFrs , $nom , $adresse)
	{
		$data = array('nomFrs' => $nom , 'adresse' => $adresse);

		$this->db->where('codeFrs' , $codeFrs);
		
		$this->db->update('fournisseur' , $data);

		return true;
	}
	public function codeFrs($nom)
	{
		$nom = $this->db->escape_str($nom);
		$sql = "SELECT codeFrs from fournisseur where nomFrs = ?";
		$result = $this->db->query($sql , array($nom));
		if($result->num_rows() == 0) return false;
		return $result->result();
	}
	
	public function listeFrs()
	{
		return $this->db->select('*')
		->from($this->fournisseur)
		->get()
		->result();
	}
	public function listeFournisseur($order = '' , $mode = 'DESC' , $limit = 0)
	{
		if(empty($order)){
			$result = $this->db->query("SELECT * from fournisseur limit $limit , 10");
		}
		else $result = $this->db->query("SELECT * from fournisseur order by $order $mode limit $limit , 10");

		if(isset($result) AND $result->num_rows() > 0) {
      	$resultat = '';
      	$data = '';
      	$resultat = $resultat."<tr><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getFournisseur(1 ,1)' onclick='getFournisseur(1)'>Code du Fournisseur <span class='glyphicon glyphicon-chevron-down'></span></th><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getFournisseur(2,1)' onclick='getFournisseur(2)'>Nom du Fournisseur <span class='glyphicon glyphicon-chevron-down'></sapn></th><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getFournisseur(3,1)' onclick='getFournisseur(3)'>Adresse <span class='glyphicon glyphicon-chevron-down'></sapn></th><th>Action</th></tr>";
      	foreach($result->result() AS $value){
      	$codeFrs = (int) $value->codeFrs;
          $data =$data."<tr>
                <td>C".$value->codeFrs."</td>
                <td>".$value->nomFrs."</td>
                <td>".$value->adresse."</td>
                <td><button class='btn btn-primary' onclick='editFournisseur(".$codeFrs.")'>Modifier&nbsp;&nbsp;<span class='glyphicon glyphicon-edit'></span></button>&nbsp;&nbsp;<button class='btn btn-danger' onclick='supprimerFournisseur(".$codeFrs.")'>Supprimer&nbsp;&nbsp;<span class='glyphicon glyphicon-trash'></span></button></td>
          </tr>";
  		}
  		
  			$resultat = "<table class='table table-bordered'>".$resultat.$data."</table>";
      
  		}
  		else
  		{
  			$resultat = "Aucun fournisseur assure notre reapprovisionnement pour l'instant";
  		}
return $resultat;
}
public function searchFournisseur($query)
	{
		$query = htmlspecialchars($query);
		$result = $this->db->query("SELECT * from fournisseur where  codeFrs LIKE '$query%' OR nomFrs LIKE '$query%' OR adresse LIKE '$query%'");
		if($result->num_rows() > 0)
			{
				$found = $result->result();
				echo json_encode($found);
			}
		else{
			echo "Aucun fournisseur ne correspond à votre requête";
		}
	}
	public function addFournisseur($nom , $adresse)
	{
		$nom = $this->db->escape_str($nom);
		$adresse = $this->db->escape_str($adresse);
		$insert = $this->db->query("INSERT into fournisseur values(NULL , '$nom' , '$adresse')");
		if($insert) return true;
		else return false;
	}
	public function checkFournisseur($codeFrs)
	{
		$chek = false;

		$result = $this->db->query("SELECT * from fournisseur where codeFrs = $codeFrs ");

		$row = $result->num_rows();

		if($row > 0 ) $chek = true;
		return $chek;
	}
	public function supprimerFournisseur($codeFrs)
	{
		$supp = false;
		if($this->checkFournisseur($codeFrs) == true)
		{
			$tab = array();
			$codeFrs = htmlspecialchars($codeFrs);
			$codeFrss = $this->db->query("SELECT numcomfrs from commandefrs where codeFrs = $codeFrs ");
			$row = $codeFrss->num_rows();
			if($row > 0)
				{
					$i = 0;
					$num = $codeFrss->result();
					foreach ($num as $key) {
						$tab[$i] = $key->numcomfrs;
						$i++;
				}
//S'il y a beaucoup de commande passé
			$this->db->query("DELETE from  commandefrs where  codeFrs = $codeFrs");
			for($i = 0 ; $i < $row ; $i++)
				{
					$this->db->query("DELETE from lignecomfrs where numcomfrs = ".$tab[$i]);
				}
			}
			$this->db->query("DELETE from fournisseur where codeFrs = $codeFrs ");
			$supp = true;
		}
		return $supp;
	}

}