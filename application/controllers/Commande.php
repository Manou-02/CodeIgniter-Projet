<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Commande extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Client_model' , 'Client');
	    $this->load->model('Produit_model' , 'Produit');
	    $this->load->model('Fournisseur_model' , 'Fournisseur');
	    $this->load->model('CommandeClient_model' , 'CommandeCli');
	    $this->load->model('CommandeFournisseur_model' , 'CommandeFrs');
		if(!isset($this->session->logged))
		redirect(base_url()."authentification/login");
	}
	public function index()
	{
		$this->acceuil();
	}
	public function client($facture = '')
	{
		$factures = array();

		
		
		if($facture != '')
			{	
				$this->load->view("menu");
				
				$factures['facture'] = $facture;
	
				$this->load->library('Lettre');
		
				$this->load->view("commande/client/acceuil" , $factures);
			}
		
		else{
			$this->load->view("menu");
			$this->load->view("commande/client/acceuil");
		}
	
	}
	public function fournisseur()
	{
		$this->load->view("menu");
		$this->load->view("commande/fournisseur/acceuil");
	}
	public function acceuil()
	{
		$this->load->view("menu");
		$this->load->view("commande/acceuil");
	}
	public function factureClient($ligne)
	{
		$ligne = (int) $ligne;
		$facture['facture'] =  $this->CommandeCli->genererFacture($ligne);;
		
		$this->load->library('Lettre');
		
		$this->load->library("Html2Pdf/Html2Pdf");

		$this->load->view('commande/client/factureClient' , $facture);
	}
	public function vente()
	{
		echo json_encode($this->CommandeCli->genererFacture());
	}
 	public function reapprovisionnement()
 	{
 		echo json_encode($this->CommandeFrs->genererFacture());
 	}
	public function commander()
	{
	
		$code = (int) $this->Client->codeCli($this->input->post('client'));
//Est-ce sue le client existe
		if($code == false)
		{
		$this->session->set_flashdata('insert' , "Le client '".$this->db->escape_str($this->input->post('client'))."' que vous avez fournis n'existe pas dans notre registre");
			$this->client();
		}
	else
	{
	
		$client = (int) $this->Client->codeCli($this->input->post('client'))[0]->codeCli;
		
		$design = array();
		
		$quantite = array();
		
		$j = 0;
//row va contenir le nombre de ligne de la commande
		$row = (count($_POST) - 1) /2;
		
		for($i = 0; $i < $row ; $i++)
			{
				if($j == 0)
					{
						$quant = 'qte';
						$select = 'selected';
					}		
				else
					{
						$quant = 'qte'.$i;
						$select = 'selected'.$i;
					}

					$prod = rtrim($_POST[$select], "".$j);

					if($this->Produit->stockSuffisant($prod , (int)$_POST[$quant]) == false)
						{
							$this->session->set_flashdata('insert' , 'Stock insuffisant pour un produit :'.$prod.'. Veuillez vous réapprovisionner pour effectuer cet achat.');
								//Stock insuffisant pour ce produit;
								$this->client();
								
								break;
								//Pour sortir directement de la boucle car un des produits est en rupture de stock;
						}
					else
					{
						$prod = (int)($this->Produit->getCodePro($prod))[0]->codePro;
							array_push($design, $prod);
							array_push($quantite, (int)$_POST[$quant]);
						$j++;
//On fait directement un array_push sur le tableau pour avoir tous les valeurs;

					$insertion = $this->CommandeCli->insertCommande($client , $design , $quantite);
				}

			}
			if(!isset($insertion))
				{
					$this->client();
				}
			else if ($insertion == true) {
				
				$this->session->set_flashdata('insert' , 'Commande passé');
				$facture = $this->CommandeCli->genererFacture($row);
				$this->client($facture);
			
			}
			else{
				$this->session->set_flashdata('insert' , 'Commande incorrect , verifiez les données passées');
				$this->client();
			}
}

}
	public function reapprovisionner()
	{
		$fr = (int) $this->Fournisseur->codeFrs($this->input->post('Fournisseur'));
if($fr == false)
{
	$this->session->set_flashdata('reappro' , "Le fournisseur '".$this->db->escape_str($this->input->post('Fournisseur'))."' que vous avez fournis n'existe pas dans notre registre");
		
		$this->fournisseur();

}
else	{

$frs = (int) $this->Fournisseur->codeFrs($this->input->post('Fournisseur'))[0]->codeFrs;
	$design = array();
			$quantite = array();
			$j = 0;
			$row = (count($_POST) - 1) /2;
			
				for($i = 0; $i < $row ; $i++)
				{
					if($j == 0)
						{
							$quant = 'qte';
							$select = 'selected';
						}		
					else
						{
							$quant = 'qte'.$i;
							$select = 'selected'.$i;
						}
						$prod = rtrim($_POST[$select], "".$j);
						$prod = (int)($this->Produit->getCodePro($prod))[0]->codePro;
						array_push($design, $prod);
						array_push($quantite, (int)$_POST[$quant]);
					$j++;
				}
			$insertion = $this->CommandeFrs->insertCommande($frs , $design , $quantite);
	
			if($insertion)
				{
					$this->session->set_flashdata('reappro' , 'Commande passé');
				}
			else{
					$this->session->set_flashdata('reappro' , 'Commande incorrect , verifiez les données passées');			
			}
			
			$this->fournisseur();
	
		}}

}
