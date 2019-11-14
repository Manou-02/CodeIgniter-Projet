<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Client extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Client_model' , 'Client');
    $this->load->model('Produit_model' , 'Produit');
    $this->load->model('Fournisseur_model' , 'Fournisseur');
    if(!isset($this->session->logged))
		redirect(base_url()."authentification/login");
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
  public function update()
  {
    $nom = $this->input->post('nom');
    $adresse = $this->db->escape_str($this->input->post('adrs'));
    $codeCli = (int) $this->input->post('codeCli');

    if(!empty($nom) || !empty($adresse))
      {
        $insertion = $this->Client->update($codeCli , $nom , $adresse);
      if($insertion){
        $this->session->set_flashdata("ajout" , "Le client a été mise à jour avec succès");
        }
      else{
        
          $this->session->set_flashdata("ajout" , "Il y a eu erreur lors de la mise à jour du client");
        }
      }
  }
  public function clientDescription()
  {
    $codeCli = (int) $this->input->get('codeCli');
    $result = $this->Client->getClientDescription($codeCli);
    echo json_encode($result);
  }
  public function getCountCli()
  {
  	if(!empty($this->input->get('count')))
  		echo $this->Client->getCountCli();
  }
  public function pdf()
  {
  	$result = $this->Client->listeCli();
  	$result['client'] = $result;
		$this->load->library("Html2Pdf/Html2Pdf");
    $this->load->view("client/listeClient" , $result);
  }
  public function listeClient()
  {
    $limit = $this->input->get("limit");

    if(!empty($this->input->get('task')))
    { 
      $order = htmlspecialchars($this->input->get("order"));
      $mode = htmlspecialchars($this->input->get("mode"));

      if(!empty($this->input->get('limit')))
        echo $this->Client->listeClient($order , $mode , $limit);
      else
        echo $this->Client->listeClient($order , $mode);
    }
  }

  public function acceuil()
  {
      $array = array();
      $array['data'] = $this->Client->chiffreAffaireChart();
      $client = $this->Client->getCountCli();
      $array['client'] = $client;
      $array['fournisseur'] = $this->Fournisseur->getCountFournisseur();
      $array['produit'] = $this->Produit->getCountProduit();
      $this->load->view("menu" , $array);
      $this->load->view("client/acceuil" , $array);
  }
  public function chiffreAffaire()
  {
    $json = $this->Client->chiffreAffaire();

    echo json_encode($json);
  }
  public function searchClient()
  {
    $query = $this->input->get("query");

    $this->Client->searchClient($query);
  }
  public function supprimerClient()
  {
    $get = (int) $this->input->get("supprimer");

    $suppresion = $this->Client->supprimerClient($get);
    
    if($suppresion){
      $this->session->set_flashdata("supprime" , "Le client a été supprimé avec succès");
    }
    else{
      $this->session->set_flashdata("supprime" , "Il y a eu erreur lors de la suppression du client");
    }
    redirect(base_url().'client/');
    
  }
  public function addClient()
  {
    $nom = htmlspecialchars($this->input->post("nom"));
    $adresse = htmlspecialchars($this->input->post("adresse"));

    if($this->Client->isExistsClient($nom , $adresse) == false)
    {
      $insertion = $this->Client->addClient($nom , $adresse);
            if($insertion == true){
          $this->session->set_flashdata("ajout" , "Le client a été ajouté avec succès");
        }
        else{
          $this->session->set_flashdata("ajout" , "Il y a eu erreur lors de l'ajout du client");
          }
      }
    redirect(base_url().'client/');
  }
  
}
