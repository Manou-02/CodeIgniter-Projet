<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ceci est le modele pour le produit
 */
class Produit_model extends CI_Model
{
	private $produit = "produit";
	
	function __construct()
	{
		parent:: __construct();
	}
	public function stockSuffisant($design , $stock)
	{
		$suffisant = false;
		$sql = "SELECT Design from produit  where Design = ? AND stock <= ?";
		$result = $this->db->query($sql , array( $design , $stock));

		if($result->num_rows() == 0)
			$suffisant = true;
		return $suffisant;
	}
	public function listeProduitPDF()
	{
		$produit = $this->db->query("SELECT * from produit order by codePro DESC");
		if($produit->num_rows() > 0)
		{
			return $produit->result();
		}
		else return false;
	}
		public function getCodePro($desing)
	{
		$desing = $this->db->escape_str($desing);

		return $this->db->select("codePro")
		->from($this->produit)
		->where(array("design" => $desing))
		->get()
		->result();
	
	}
	public function approvisionnement($codePro , $qte)
	{
		$sql = "UPDATE produit set stock = stock + ? where codePro = ?";
		$this->db->query($sql , array( $qte , $codePro));
	}
	public function commande($codePro , $qte)
	{
		$sql = "UPDATE produit set stock = stock - ? where codePro = ?";
		$this->db->query($sql , array( $qte , $codePro));
	}
	public function getProduitBrut()
	{
		return $this->db->select("design")
						->order_by("design" , 'ASC')
						->from($this->produit)
						->get()
						->result();
	}
//On va essayer d'ecrire une fonction qui peut faire à la fois ordonner et afficher avec des limites les produits
	public function listeProduit($order = '' , $mode = 'DESC' , $limit = 0)
	{
		if(empty($order)){
			$result = $this->db->query("SELECT * from produit limit $limit , 10");
		}
		else $result = $this->db->query("SELECT * from produit order by $order $mode limit $limit , 10");

		if(isset($result) AND $result->num_rows() > 0) {
      	$resultat = '';
      	$data = '';
      	$resultat = $resultat."<tr><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(1 ,1)' onclick='getProduit(1)'>Code du produit <span class='glyphicon glyphicon-chevron-down'></span></th><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(2,1)' onclick='getProduit(2)'>Designation <span class='glyphicon glyphicon-chevron-down'></sapn></th><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(3,1)' onclick='getProduit(3)'>Prix unitaire (Ar) <span class='glyphicon glyphicon-chevron-down'></sapn></th><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(4,1)' onclick='getProduit(4)'>Stock actuel (Kg) <span class='glyphicon glyphicon-chevron-down'></sapn></th><th>Action</th></tr>";
      	foreach($result->result() AS $value){
      	$codePro = (int) $value->codePro;
          $data =$data."<tr>
                <td>P".$value->codePro."</td>
                <td>".$value->Design."</td>
                <td>".$value->PU.",00</td>
                <td>".$value->stock."</td>
                <td><button class='btn btn-primary' onclick='editProduit(".$codePro.")'>Modifier&nbsp;&nbsp;<span class='glyphicon glyphicon-edit'></span></button>&nbsp;&nbsp;<button class='btn btn-danger' onclick='supprimerProduit(".$codePro.")'>Supprimer&nbsp;&nbsp;<span class='glyphicon glyphicon-trash'></span></button></td>
          </tr>";
  		}
  		
  			$resultat = "<table class='table table-bordered'>".$resultat.$data."</table>";
      
  		}
  		else
  			$resultat = "Aucun produit n'est disponible en magasin pour le moment";
return $resultat;
}
//Pour la recherche des produits;
	public function searchProduit($query)
	{
		$query = $this->db->escape_str(htmlspecialchars($query));
		$result = $this->db->query("SELECT * from produit where  codePro LIKE '$query%' OR Design LIKE '$query%' OR stock LIKE '$query%' OR PU LIKE '$query%' ");
		if($result->num_rows() > 0)
			{
				$found = $result->result();
				echo json_encode($found);
			}
		else{
			echo "Aucun produit ne correspond à votre requête";
		}
	}
	public function getCountProduit()
	{
		return $this->db->count_all_results($this->produit);
	}
//Pour les produits qui ont besoin de reapprovisionnement
	public function reapprovisionnement()
	{
		$result = $this->db->query("SELECT * from produit where stock < 20");
		if($result->num_rows() > 0)
		return $result->result();
		else return "Nothing";
	}

	public function addProduit($design , $pu)
	{
		$design = $this->db->escape_str($design);
		$insert = $this->db->query("INSERT into produit values(NULL , '$design' , $pu , 0)");
		if($insert) return true;
		else return false;
	}
	public function checkProduit($codePro)
	{
		$chek = false;

		$result = $this->db->query("SELECT * from produit where codePro = $codePro ");

		$row = $result->num_rows();

		if($row > 0 ) $chek = true;
		return $chek;
	}
	public function supprimerProduit($codePro)
	{
		$supp = false;
		if($this->checkProduit($codePro) == true)
		{
			$codePro = htmlspecialchars($codePro);
			$this->db->query("DELETE from produit where codePro = $codePro ");
			$supp = true;
		}
		return $supp;
	}
	public function chartProduit()
	{
		$datas = array();
		$backColor = '';
		$label = '';
		$data = '';
		$sql = $this->db->query("SELECT design , stock from produit");
		$produit = $sql->result();

		foreach ($produit as $value) {
				$backColor = $backColor."'rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).",.75)',";
				$label = $label."'".($value->design)."',";
				$data = $data.($value->stock).",";
			}
		$label = rtrim($label , ",");
		$data = rtrim($data , ",");
		$backColor = rtrim($backColor , ",");

		$datas['label'] = $label;
		$datas['data'] = $data;
		$datas['bgcolor'] = $backColor;
		return $datas;
	}
	public function mostCommander()
	{
		$produit = $this->db->query("SELECT design , count(qteCom) AS com, sum(qteCom) AS qte from produit , lignecomcli  where lignecomcli.codePro = produit.codePro  group by produit.codePro");
			$design = '';
			$bg = '';
			$vente = '';
			$appro='';
			$bg1 = '';
			$exchange = array();
			$row = $produit->result();
			foreach ($row as $echange) {
			 	$design = $design."'".$echange->design."',";
		  		$vente = $vente.($echange->com).',';
		  		$appro = $appro.($echange->qte).",";
		  		$bg = $bg."'rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).")',";
		  		$bg1 = $bg; 
			 }
			 $design = rtrim($design , ",");
			 $vente = rtrim($vente , ",");
			 $appro = rtrim($appro , ",");
			 $bg = rtrim($bg , ",");
			 $bg1 = rtrim($bg1 , ",");
		
		$exchange['design'] = $design;
		$exchange['com'] = $vente;
		$exchange['qte'] = $appro;
		$exchange['bg1'] = $bg1;
		$exchange['bg'] = $bg;

		return $exchange;
	}
	
	public function balanceProduit()
	{
		$result =  $this->db->query("SELECT design , sum(qtecom) AS com , sum(qteappro) AS appro from produit,lignecomcli ,  lignecomfrs where lignecomfrs.codepro = produit.codepro and lignecomcli.codepro = lignecomfrs.codepro group by lignecomcli.codepro");
		$design = '';
		$vente = '';
		$appro = '';
		$exchange = array();
		$row = $result->result();
		foreach ($row as $echange) {
		 	$design = $design."'".$echange->design."',";
	  		$vente = $vente.$echange->com.',';
	  		$appro = $appro.$echange->appro.",";
		 }
		 $design = rtrim($design , ",");
		 $vente = rtrim($vente , ",");
		 $appro = rtrim($appro , ",");
	
	$exchange['design'] = $design;
	$exchange['com'] = $vente;
	$exchange['appro'] = $appro;

	return $exchange;
	}

	public function getProduitDescription($codePro)
	{
		$sql = "SELECT codePro , design , PU from produit where codePro = ?";
		$result = $this->db->query($sql , array($codePro));

		return $result->result();
	}
	public function update($codePro , $design , $pu)
	{
		$data = array('design' => $design , 'PU' => $pu);

		$this->db->where('codePro' , $codePro);
		
		$this->db->update('produit' , $data);

		return true;
	}
}