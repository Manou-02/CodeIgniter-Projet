<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlleur pour les produit où on va traiter de l'ajax
 */
class Produit extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Client_model' , 'Client');
	    $this->load->model('Produit_model' , 'Produit');
		$this->load->model('Fournisseur_model' , 'Fournisseur');
		if(!isset($this->session->logged))
		redirect(base_url()."authentification/login");	
	}
	public function update()
	{
		$design = $this->input->post('design');
		$pu = (int) $this->input->post('pu');
		$codepro = (int) $this->input->post('codePro');

		if(!empty($design) || !empty($pu))
			{
				$insertion = $this->Produit->update($codepro , $design , $pu);
			if($insertion){
				$this->session->set_flashdata("ajout" , "Le produit a été mise à jour avec succes");
				}
			else{
				
					$this->session->set_flashdata("ajout" , "Il y a eu erreur lors de la mise à jour du produit");
				}
			}
	}
	public function produitDescription()
	{
		$codePro = $this->db->escape_str($this->input->get('codePro'));
		$result = $this->Produit->getProduitDescription($codePro);
		echo json_encode($result);
	}
	public function getProduitBrut()
	{
		echo json_encode($this->Produit->getProduitBrut());
	}
	public function index()
	{
		if(isset($this->session->logged))
	    {
	        $this->acceuil();
	    }
	    else
	    {
	      $admin = $this->db->query('SELECT * from admin');
	      
	      if($admin->num_rows() > 0)
	        {
	            $this->session->set_flashdata( "Error" , "You must log in first");
	            redirect(base_url()."authentification/login");
	        }

		}
	}
	public function acceuil()
	{
		$array = array();
		$array['client'] = $this->Client->getCountCli();
	    $array['fournisseur'] = $this->Fournisseur->getCountFournisseur();
	    $array['produit'] = $this->Produit->getCountProduit();
	
		$this->load->view("menu" , $array);
		$count = $this->Produit->getCountProduit();
		$array['produit'] = $count;
		if($count < 10)
		{
			$count = 1;
		}	
		else
		{
			if($count % 10 == 0)
				$count = $count / 10;
			else
				$count = (($count - ($count % 10 ))/ 10) + 1;
			}
		$array['count'] = $count;
		$array['most'] = $this->Produit->mostCommander();
		$this->load->view("produit/acceuil" , $array);

	}
	public function listeProduit()
	{
		$limit = $this->input->get("limit");

		if(!empty($this->input->get('task')))
		{	
			$order = htmlspecialchars($this->input->get("order"));
			$mode = htmlspecialchars($this->input->get("mode"));

			if(!empty($this->input->get('limit')))
				echo $this->Produit->listeProduit($order , $mode , $limit);
			else
				echo $this->Produit->listeProduit($order , $mode);
		}
	}
	public function searchProduit()
	{
		$query = $this->input->get("query");

		$this->Produit->searchProduit($query);
	}
	public function getCountProd()
	{
		echo $this->Produit->getCountProduit();
	}

	public function supprimerProduit()
	{
		$get = (int) $this->input->get("supprimer");

		$suppresion = $this->Produit->supprimerProduit($get);
		
		if($suppresion){
			$this->session->set_flashdata("supprime" , "Le produit a été supprimé avec succes");
		}
		else{
			$this->session->set_flashdata("supprime" , "Il y a eu erreur lors de la suppression du produit");
		}
		redirect(base_url().'produit/');
		
	}
//Qui va generer le pdf de la liste des produits

	public function addProduit()
	{
		$design = htmlspecialchars($this->input->post("design"));
		$prix = htmlspecialchars($this->input->post("prix"));

		$insertion = $this->Produit->addProduit($design , $prix);
				if($insertion){
			$this->session->set_flashdata("ajout" , "Le produit a été ajouté avec succes");
		}
		else{
			$this->session->set_flashdata("ajout" , "Il y a eu erreur lors de l'ajout du produit");
			}
		redirect(base_url().'produit/');
	}
	public function pdf()
	{
		$produit = $this->Produit->listeProduitPDF();
		if($produit != false)
			{
				$produit['produit'] = $produit;
				$this->load->library("Html2Pdf/Html2Pdf");
				$this->load->view("produit/listeProduit" , $produit);
			}
	}
	public function chart()
	{
		$data = $this->Produit->chartProduit();
		var_dump($data);
	}
}