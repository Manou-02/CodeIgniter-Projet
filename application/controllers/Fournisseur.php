<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Fournisseur extends CI_Controller
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
  public function getCountFrs()
  {
    if(!empty($this->input->get('count')))
      echo $this->Fournisseur->getCountFournisseur();
  }
  public function pdf()
  {
    $result['fournisseur'] = $this->Fournisseur->listeFrs();
    $this->load->library("Html2Pdf/Html2Pdf");
    $this->load->view("fournisseur/listeFournisseur" , $result);
  }
  public function listeFournisseur()
  {
    $limit = $this->input->get("limit");

    if(!empty($this->input->get('task')))
    { 
      $order = htmlspecialchars($this->input->get("order"));
      $mode = htmlspecialchars($this->input->get("mode"));

      if(!empty($this->input->get('limit')))
        echo $this->Fournisseur->listeFournisseur($order , $mode , $limit);
      else
        echo $this->Fournisseur->listeFournisseur($order , $mode);
    }
  }
public function update()
  {
    $nom = $this->input->post('nom');
    $adresse = $this->db->escape_str($this->input->post('adrs'));
    $codeFrs = (int) $this->input->post('codeFrs');

    if(!empty($nom) || !empty($adresse))
      {
        $insertion = $this->Fournisseur->update($codeFrs , $nom , $adresse);
      if($insertion){
        $this->session->set_flashdata("ajout" , "Le fournisseur a été mise à jour avec succes");
        }
      else{
        
          $this->session->set_flashdata("ajout" , "Il y a eu erreur lors de la mise à jour du fournisseur");
        }
      }
  }
  public function fournisseurDescription()
  {
    $codeFrs = (int) $this->input->get('codeFrs');
    $result = $this->Fournisseur->getFournisseurDescription($codeFrs);
    
    echo json_encode($result);
  }
  public function acceuil()
  {
      $array = array();
      
      $array['client'] = $this->Client->getCountCli();
      $array['fournisseur'] = $this->Fournisseur->getCountFournisseur();
      $array['produit'] = $this->Produit->getCountProduit();
      $this->load->view("menu" , $array);
      $this->load->view("Fournisseur/acceuil" , $array);
  }

  public function searchFournisseur()
  {
    $query = $this->input->get("query");

    $this->Fournisseur->searchFournisseur($query);
  }
  public function supprimerFournisseur()
  {
    $get = (int) $this->input->get("supprimer");

    $suppresion = $this->Fournisseur->supprimerFournisseur($get);
    
    if($suppresion){
      $this->session->set_flashdata("supprime" , "Le fournisseur a été supprimé avec succes");
    }
    else{
      $this->session->set_flashdata("supprime" , "Il y a eu erreur lors de la suppression du fournisseur");
    }
    redirect(base_url().'Fournisseur/');
    
  }
  public function addFournisseur()
  {
    
    $nom = htmlspecialchars($this->input->post("nomFrs"));
    $adresse = htmlspecialchars($this->input->post("adresse"));

    $insertion = $this->Fournisseur->addFournisseur($nom , $adresse);
        if($insertion){
      $this->session->set_flashdata("supprime" , "Le fournisseur a été ajouté avec succes");
    }
    else{
      $this->session->set_flashdata("supprime" , "Il y a eu erreur lors de l'ajout du fournisseur");
      }
    redirect(base_url().'fournisseur/');
  }
  
}
