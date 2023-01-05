<?php

class Controller_auth extends Controller{

  public function action_form_login()
  {
    $m = Model::getModel();
    $data = []; 

    $this->render("login", $data);
  }

  public function action_login(){

    $m = Model::getModel();

    // Vérifie si l'utilisateur a soumis le formulaire de connexion
    if (isset($_POST['Email']) and isset($_POST['Password'])) {
      // Récupère les informations de connexion
      /* 
      TODO: Faire une fonction getIdClientFromEmail($email)
      faut que email deviennent un id client ou id admin ou num etudiant
      */
      $username = $_POST['Email'];
      $password = $_POST['Password'];
      $admin = 'admin';
      $client = 'client';
      // Vérifier si l'utilisateur existe dans la base de données avec les fonction isInDatabaseClient et isInDatabaseAdmin 
      if ($m->isInDatabaseAdmin($username)){
            // Vérifier si le mot de passe saisie est correct 
            if (password_verify($password, $m->getPassword($username,"Admin"))){

                session_start();
                
                // Enregistre l'utilisateur dans la session
                $_SESSION['id_etud'] = $username;
                $_SESSION['connected'] = true;
                $_SESSION['statut'] = $admin;
                // Redirige l'admin vers la page d'accueil admin
                $data = [
                    "nomprenom" => $m->getPrenomNomAdmin($username)
                    ]; 
                $this->render("espace_admin", $data);
            }
      }
      elseif ($m->isInDatabaseClient($username)){
        // Vérifier si le mot de passe saisie est correct
        if(password_verify($password, $m->getPassword($username,"Client"))){

                session_start();
                
                // Enregistre l'utilisateur dans la session
                $_SESSION['id_etud'] = $username;
                $_SESSION['connected'] = true;
                $_SESSION['statut'] = $client;
                
                // Redirige le client vers la page d'accueil client
                $data = [
                    "nomprenom" => $m->getPrenomNomClient($username)
                    ]; 
                //$this->render("espace_client", $data);
                $this->render("espace_client", $data);
        }
      }

      else {
        // Affiche un message d'erreur
        $this->action_error("Erreur, identifiant ou mot de passe non saisis.");
      }
    }

    else {
      // Affiche un message d'erreur
      $this->action_error("Erreur, identifiant ou mot de passe incorrect.");
    }
    
    
    }
    
    public function action_form_signup(){
        $m = Model::getModel();
        $data = []; 

        $this->render("signup", $data);
    }

    public function action_signup(){

      $ajout = false;

      //Test si les informations nécessaires sont fournies
      /* exemple de vérification
      if (isset($_POST["name"]) and ! preg_match("/^ *$/", $_POST["name"])
          and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
          and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
      */
      
      if (isset($_POST["num_etudiant"]) && 
      isset($_POST["Nom"]) && 
      isset($_POST["Prenom"]) && 
      isset($_POST["Password"]==$_POST["Password_verify"]) &&
      isset($_POST['Email']))
      {
        if($m->isInDatabaseClient($_POST['Email'])){

          $this->action_error("L'adresse mail est déjà utilisée, Veuillez en saisir une autre ");

        }
        else{
          // !!
          // RAJOUTER DES TESTS / CONTROLE DE SAISIE DANS LE IF !!!
          // !!
          $tab = [
            "id_client" => $m->getDernierIdDisponible("Client"),
            "num_etudiant" => $_POST["num_etudiant"], 
            "Nom" => $_POST["Nom"], 
            "Prenom" => $_POST["Prenom"], 
            "Tel" => $_POST["Tel"], 
            "Email" => $_POST["Email"], 
            "Date_creation" => date("Y-m-d"), 
            "Pts_fidelite" => 0
          ];
          // On vérifie que la catégorie est une des catégories possibles
          $m = Model::getModel();
          // Préparation du tableau infos
          $infos = [];
          $noms = ["id_client", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
          foreach ($noms as $v) {
              if (isset($tab[$v]) && ((is_string($tab[$v]) && ! preg_match("/^ *$/", $tab[$v])) || ((is_int($tab[$v]) || is_float($tab[$v])) && $tab[$v]>=0))) {
                // && (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0)
                $infos[$v] = $tab[$v];
                //debug
                //echo "Ajout $v OK";
              } else {
                $infos[$v] = null;
                //echo "Ajout $v OK, valeur NULL";
              }
          }

          $infosAuth = [$_POST["num_etudiant"], password_hash($_POST["Password"], PASSWORD_DEFAULT)];



          //Récupération du modèle
          $m = Model::getModel();
          //Ajout du produit
          $m->addAuthClient($infosAuth);
          $ajout = $m->addClient($infos);
          
      }
      }
      else{
        $this->action_error("Erreur, des informations n'ont pas été saisies ou le mot de passe n'est pas correspondant.");
      }
      

      //Préparation de $data pour l'affichage de la vue message
      $data = [
          "title" => "Bienvenue parmi le Wolf BDE !",
          "added_element" => "client",
          "str_lien_retour" => "Retour à la page de gestion d'accueil",
          "lien_retour" => "?controller=home&action=home" 
      ];
      if ($ajout) {
          $data["message"] = "Votre inscription a bien été prise en compte, " . $_POST["Prenom"] . " " . $_POST["Nom"] . ". Vous pouvez maintenant vous connecter à votre espace client.";
      } else {
          $data["message"] = "Erreur dans la saisie des informations, le compte client n'a pas été ajouté.";
      }

      $this->render("message", $data);

      
    }
        


    public function action_oublimdp(){
      if(isset($_POST['Email'])){

        $password = uniqid();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $message = "Bonjour, voici votre nouveau mot de passe : $password";
        $headers = 'Content-Type: text/plain; charest="utf-8"'." ";
        
        if(mail($_POST['Email'], 'Mot de passe oublié',$message, $headers)){
    
          if($m->isInDatabaseAdmin($email)){

            $table = "Admin";
            $m->updatePassword($email,$hashedPassword,$table);        

          }
          elseif($m->isInDatabaseClient($email)){

            $table = "Client";
            $m->updatePassword($email,$hashedPassword,$table);

          }
            
        }
        else{
    
            $this->action_error("Une erreur est survenue .. ");
    
        }
    }
  }


    public function action_default(){

        $this->action_form_login();
    }

}
?>
