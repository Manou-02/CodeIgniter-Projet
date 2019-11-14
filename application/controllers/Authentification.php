<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Authentification extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
      $this->load->model('Authentification_model' , 'Auth');
      $this->load->model('Client_model' , 'Client');
      $this->load->model('Produit_model' , 'Produit');
      $this->load->model('Fournisseur_model' , 'Fournisseur');
  }
  public function delete()
  {
    if(!isset($this->session->logged))
        {
          $this->login();
        }
    else
      {
        $this->Auth->deleteAdmin();
        $this->index();
      }
  }
  public function index()
  {
    if(isset($this->session->logged) AND $this->session->logged == true)
    {
        $this->acceuil();
    }
    else
    {
      $admin = $this->db->query('SELECT * from admin');
      
      if($admin->num_rows() > 0)
        {
            $this->session->set_flashdata( "Error" , "You must log in first");
            $this->login();
        }    
      else
        {
            $this->session->set_flashdata( "Error" , "Please register as admin");
            $this->register();
        }
    }
}

  public function acceuil()
  {
        if(!isset($this->session->logged))
        {
          $this->login();
        }
        else
        {
            $array = array();
        
            $array['chart'] = $this->Produit->chartProduit();
        
            $array['exchange'] = $this->Produit->balanceProduit();
        
            $array['client'] = $this->Client->getCountCli();
        
            $array['fournisseur'] = $this->Fournisseur->getCountFournisseur();
        
            $array['produit'] = $this->Produit->getCountProduit();
        
           $array['most'] = $this->Produit->mostCommander();
        
            if($this->Produit->reapprovisionnement() == "Nothing")
            {
               $this->load->view("acceuil" , $array);
            }
            else
            {
                $array['provision'] = $this->Produit->reapprovisionnement();
                
                if($this->session->userdata('logged') == true)
                  {
                    $this->load->view("acceuil" , $array);
                  }
                else
                {
                    $admin = $this->db->query('SELECT * from admin');
                  
                  if($admin->num_rows() > 0)
                      {
                        $this->session->set_flashdata( "Error" , "You must log in first");
                        $this->login();
                      }
        
              
                  else
                      {
                        $this->session->set_flashdata( "Error" , "Please register as admin");
                        $this->register();
                      }
                  
                }
            }
      }    
}
  function search()
  {
   $get = $this->input->get("query");

    $this->Auth->search($get);
  }
  function validation()
  {
      $this->form_validation->set_rules("pseudo" , "pseudo" , "required|trim|min_length[4]");
      $this->form_validation->set_rules("password" , "password" , "required|trim|min_length[6]");
      if($this->form_validation->run() == true)
      {
          $usr = $this->input->post("pseudo");
          $mdp = $this->input->post("password");
          $can_log = $this->Auth->checkUser($usr , $mdp);
          if($can_log == true)
            {
              $this->session->set_userdata(array('pseudo' => $usr , 'logged' => true));
              redirect(base_url().'authentification/acceuil');
            }
            else
              $this->login();
      }
      else
      {
              $this->session->set_flashdata("Error" , "Wrong username or password");
              $this->login();
      }

  }
  public function login()
  {
      $this->load->view("auth/login");
  }
  public function logout()
  {
      $this->session->sess_destroy();
      $this->login();
  }
  public function registration()
  {
    $nom = $this->input->post('nom');
    $user = $this->input->post('user');
    $mdp = $this->input->post('mdp');
    $confirm = $this->input->post('confirm');
    $email = $this->input->post('email');
    $contract = $this->input->post('contract');
        
        $this->form_validation->set_rules('nom' , 'nom' , 'required|min_length[6]');
        $this->form_validation->set_rules('confirm' , 'confirm' , 'required|min_length[6]');
        $this->form_validation->set_rules('mdp' , 'password' , 'required|min_length[6]');
        $this->form_validation->set_rules('email' , 'e-mail' , 'required|trim');
        $this->form_validation->set_rules('user' , 'pseudo' , 'required|min_length[6]');
    
    if($this->form_validation->run())
    {
      if($contract != 'on')
        {
          echo 'You must accept the term of contract';
        }
      else
        {
          $insert = $this->Auth->register($nom , $user , $email , $mdp , $confirm);
          
          if($insert == true)
            echo "Inscription complète. Commencer à se connecter avec votre <a href='".base_url()."authentification/login'>nouveau compte</a>.";
          else
            echo "Inscription incomplète, les deux mots de passes que vous avez fournis ne correspondent pas";
        }
    }
    else
      echo "Respecter les prerequis";
    
  }
  public function register()
  {
    $this->load->view('auth/register');
  }
}
