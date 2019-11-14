<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Client_model extends CI_Model
{

	protected $table = 'client';

	public function codeCli($nom)
	{
		$nom = $this->db->escape_str($nom);
		$sql = "SELECT codeCli from client where nomCli = ?";
		$result = $this->db->query($sql , array($nom));
		if($result->num_rows() == 0) return false;
		return $result->result();
	}
	private function filter($nom , $adrs)
	{
		if(is_string($nom) && is_string($adrs)) return true;
		else false;
	}
	public function getCountCli()
	{
		return $this->db->count_all_results($this->table);
	}
	public function listeCli()
	{
		return $this->db->select('*')
					->from($this->table)
					->get()
					->result();
	}
	public function listeClient($order = '' , $mode = 'DESC' , $limit = 0)
	{
		if(empty($order)){
			$result = $this->db->query("SELECT * from client limit $limit , 10");
		}
		else $result = $this->db->query("SELECT * from client order by $order $mode limit $limit , 10");

		if(isset($result) AND $result->num_rows() > 0) {
      	$resultat = '';
      	$data = '';
      	$resultat = $resultat."<tr><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getClient(1 ,1)' onclick='getClient(1)'>Code du client <span class='glyphicon glyphicon-chevron-down'></span></th><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getClient(2,1)' onclick='getClient(2)'>Nom du client <span class='glyphicon glyphicon-chevron-down'></sapn></th><th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getClient(3,1)' onclick='getClient(3)'>Adresse <span class='glyphicon glyphicon-chevron-down'></sapn></th><th>Action</th></tr>";
      	foreach($result->result() AS $value){
      	$codeCli = (int) $value->codeCli;
          $data =$data."<tr>
                <td>C".$value->codeCli."</td>
                <td>".$value->nomCli."</td>
                <td>".$value->adresse."</td>
                <td><button class='btn btn-primary' onclick='editClient(".$codeCli.")'>Modifier&nbsp;&nbsp;<span class='glyphicon glyphicon-edit'></span></button>&nbsp;&nbsp;<button class='btn btn-danger' onclick='supprimerClient(".$codeCli.")'>Supprimer&nbsp;&nbsp;<span class='glyphicon glyphicon-trash'></span></button></td>
          </tr>";
  		}
  		
  			$resultat = "<table class='table table-bordered'>".$resultat.$data."</table>";
      
  		}
  		else
  			$resultat = "Aucun client n'est abonné au magasin";
return $resultat;
}
//Données pour le tableau
	public function chiffreAffaire()
	{
		$ca = $this->db->query("SELECT client.codeCli , nomcli , sum(qteCom*pu) AS chiffre from produit , client , lignecomcli , commande_cli where produit.codePro = lignecomcli.codePro and commande_cli.codeCli = client.codeCli and lignecomcli.numcomcli = commande_cli.numcomcli group by nomcli");
		$row = $ca->result();
		return $row;		
	}
//Données pour créer le graphe
	public function chiffreAffaireChart()
	{
		$data = array();
		$code = '';
		$nom = '';
		$chiffre = '';
		$backColor = '';
		$result = $this->chiffreAffaire();
		foreach ($result as $key) {
			$codeCli = (int)$key->codeCli;
			$chiffreAffaire = (int)$key->chiffre;

			$nom = $nom."'".$key->nomcli."',";
			$code = $code.$codeCli.",";
			$chiffre = $chiffre.$chiffreAffaire.",";
			$backColor = $backColor."'rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).",.75)',";
		}
		$nom = rtrim($nom , ",");
		$code = rtrim($code , ",");
		$chiffre = rtrim($chiffre , " ,");
		$backColor = rtrim($backColor , ",");
		$data['nom'] = $nom;
		$data['code'] = $code;
		$data['chiffre'] = $chiffre;
		$data['bgcolor'] = $backColor;
		
		return $data;
	}
//Recherche des clients
	public function searchClient($query)
	{
		$query = $this->db->escape_str(htmlspecialchars($query));
		$result = $this->db->query("SELECT * from client where  codeCli LIKE '$query%' OR nomCli LIKE '$query%' OR adresse LIKE '$query%'");
		if($result->num_rows() > 0)
			{
				$found = $result->result();
				echo json_encode($found);
			}
		else{
			echo "Aucun client ne correspond à votre requête";
		}
	}
	public function addClient($nom , $adresse)
	{

		$nom = $this->db->escape_str($nom);
		$adresse = $this->db->escape_str($adresse);
		
		$filtre = $this->filter($nom , $adresse);

		if($filtre == false)
			return false;
		else{
			$insert = $this->db->query("INSERT into client values(NULL , '$nom' , '$adresse')");
				if($insert) return true;
				else return false;
		}
	}
	public function isExistsClient($nom,$adresse)
	{
		$sql = "SELECT * from client where nomCli = ? and adresse = ?";
		$c = $this->db->query($sql , array($nom , $adresse));
		if($c->num_rows() > 0)
			return true;
		return false;
	}
	public function checkClient($codeCli)
	{
		$chek = false;

		$result = $this->db->query("SELECT * from client where codeCli = $codeCli ");

		if( $result->num_rows() > 0 ) $chek = true;

		return $chek;
	}
	public function supprimerClient($codeCli)
	{
		$supp = false;
		if($this->checkClient($codeCli) == true)
		{
			$tab = array();
			$codeCli = htmlspecialchars($codeCli);
			$codecli = $this->db->query("SELECT numcomcli from commande_cli where codecli = $codeCli");
			$row = $codecli->num_rows();
			if($row > 0)
				{
					$i = 0;
					$num = $codecli->result();
					foreach ($num as $key) {
						$tab[$i] = $key->numcomcli;
						$i++;
					}

			$this->db->query("DELETE from  commande_cli where  codecli = $codeCli");
			for($i = 0 ; $i < $row ; $i++)
				{
					$this->db->query("DELETE from lignecomcli where numcomcli = ".$tab[$i]);
				}
			}
			$this->db->query("DELETE from client where codeCli = $codeCli ");
			$supp = true;
		}
		return $supp;
	}
	public function getClientDescription($codeCli)
	{
		$sql = "SELECT codeCli , nomCli , adresse from client where codeCli = ?";
		$result = $this->db->query($sql , array($codeCli));

		return $result->result();
	}
	public function update($codeCli , $nom , $adresse)
	{
		$data = array('nomCli' => $nom , 'adresse' => $adresse);

		$this->db->where('codeCli' , $codeCli);
		
		$this->db->update('client' , $data);

		return true;
	}
}
