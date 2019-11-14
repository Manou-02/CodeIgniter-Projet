<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *C'est ici que se passe les authentifications
 */
class Authentification_model extends CI_Model
{

  protected $user = 'user';
  protected $admin = 'admin';
  protected $nom = 'nom';
  protected $pseudo = 'pseudo';
  protected $mail = 'mail';
  protected $mdp = 'mdp';

  function __construct()
  {
    parent::__construct();
  }
#On a check qui attend en parametre un login et un mot de passe
  public function checkUser($login , $mdp)
  {
    $check = false;
    $login = htmlspecialchars($login);
    $mdp = htmlspecialchars($mdp);
      
      $sql = "SELECT * from ".$this->admin." where pseudo = ? AND mdp = ?";

      $result = $this->db->query($sql , array($login , $mdp));
      
      $row = $result->num_rows();
      if($row != 0)
        $check = true;
      return $check;
  }
#Echape les guillets et elimine les possibles failles

  function sanitazing($nom , $pseudo  , $mail , $mdp ,$confirm)
  {
    $nom = htmlspecialchars($nom);
    $pseudo = htmlspecialchars($pseudo);
    $mail = htmlspecialchars($mail );
    $mdp = htmlspecialchars($mdp);
    $confirm = htmlspecialchars($confirm);
    
    if($confirm == $mdp)
     return true;
     else return false;
      
      
  }
//Mbola mila ovaina ny champ pour la recherche
  function search($query='')
  {
    if($query == '')
    {
      $res = "";
    }
    else{
    $query = htmlspecialchars($query);
    $sql1 = "SELECT * from produit where Design LIKE '$query%' ";
    
    $sql2= "SELECT * from client where nomCli LIKE '$query%' ";
    
    $sql3 = "SELECT * from fournisseur where nomFrs LIKE '$query%' ";
    
    $result1 = $this->db->query($sql1);
    $result2 = $this->db->query($sql2);
    $result3 = $this->db->query($sql3);
    
    $row1 = $result1->num_rows();
    $row2 = $result2->num_rows();
    $row3 = $result3->num_rows();
    
    $search1 = $result1->result();
    $search2 = $result2->result();
    $search3 = $result3->result();
//Les valuers possibles de la recherche : soit on a une correspondance pour chaque table soit l'une d'entre elles

    /*
    row1 => produit
    row2 => client
    row3 => fourniisseur
    */
$resultat_tout = array();
    if($row1 > 0 AND $row2 == 0 AND $row3 == 0){
      
      foreach ($search1 as $key) {
        array_push($resultat_tout, $key->Design." (Produit)");
      }
    }
    
    else if ($row2 > 0 AND $row1 == 0 AND $row3 == 0) {
      
            foreach ($search2 as $key) {
        array_push($resultat_tout, $key->nomCli." (Client)");
      }
    }

    else if ($row3 > 0 AND $row1 == 0 AND $row2 == 0) {
      
      foreach ($search3 as $key) {
        array_push($resultat_tout, $key->nomFrs." (Fournisseur)");
      }
    }
    
    else if ($row2 == 0 AND $row1 > 0 AND $row3 > 0) {
      
      foreach ($search1 as $key) {
        array_push($resultat_tout, $key->Design." (Produit)");
      }
            foreach ($search3 as $key) {
        array_push($resultat_tout, $key->nomFrs." (Fournisseur)");
      }
    }

    else if ($row3 == 0 AND $row1 > 0 AND $row2 > 0) {
      
      foreach ($search1 as $key) {
        array_push($resultat_tout, $key->Design." (Produit)");
      }
            foreach ($search2 as $key) {
        array_push($resultat_tout, $key->nomCli." (Client)");
      }
    }
    
    else if ($row1 == 0 AND $row2 > 0 AND $row3 > 0) {
            foreach ($search2 as $key) {
        array_push($resultat_tout, $key->nomCli." (Client)");
      }      foreach ($search3 as $key) {
        array_push($resultat_tout, $key->nomFrs." (Fournisseur)");
      }
    }

    else if($row1 > 0 AND $row3 > 0 AND $row2 > 0)
    {
      foreach ($search1 as $key) {
        array_push($resultat_tout, $key->Design." (Produit)");
      }
            foreach ($search2 as $key) {
        array_push($resultat_tout, $key->nomCli." (Client)");
      }
            foreach ($search3 as $key) {
        array_push($resultat_tout, $key->nomFrs." (Fournisseur)");
      }
    }
    else {
      $nothing =  "Aucun resultat pour cette recherche";
      array_push($resultat_tout, $nothing);
    }
    $res = '';
    for($i = 0; $i < count($resultat_tout); $i++)
    {
        $res .= "<tr><th>".$resultat_tout[$i]."</th></tr>";
    }
  }
  echo $res;
  }
  function register($nom , $user , $mail , $mdp , $mdp_confirm)
  {
    $insert = false;
      
      if($this->sanitazing($nom , $user , $mail , $mdp , $mdp_confirm) == true)
      {
          $data = array(
            $this->nom => $nom,
            $this->pseudo => $user,
            $this->mail => $mail ,
            $this->mdp => $mdp
          );
          $insertion = $this->db->insert($this->admin , $data);

          $insert =  true;
      
      }
      return $insert;
  }

  public function deleteAdmin()
  { 
      $this->session->sess_destroy();
      $sql = "DELETE from admin";
      $this->db->query($sql);
  }
}
