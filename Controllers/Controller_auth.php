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
    if (isset($_POST['submit'])) {
      // Récupère les informations de connexion
      /* 
      TODO: Faire une fonction getIdClientFromEmail($email)
      faut que email deviennent un id client ou id admin ou num etudiant
      */
      $username = $_POST['email'];
      $password = $_POST['password'];
    }


    // Vérifier si l'utilisateur existe dans la base de données avec les fonction isInDatabaseClient et isInDatabaseAdmin 
    if ($m->isInDatabaseAdmin($username)){
        session_start();
        
        // Enregistre l'utilisateur dans la session
        $_SESSION['id_etud'] = $username;
        
        // Redirige l'admin vers la page d'accueil admin
        $data = [
            // "nom" => $m->getPrenomNomAdmin($username)
            ]; 
        $this->render("espace_client", $data);
    }
    
    elseif ($m->isInDatabaseClient($username)){
    
        session_start();
        
        // Enregistre l'utilisateur dans la session
        $_SESSION['id_etud'] = $username;
        
        // Redirige le client vers la page d'accueil client
        $data = [
            // "nom" => $m->getPrenomNomClient($username)
            ]; 
        $this->render("espace_client", $data);
    } 
    
    else {
      // Affiche un message d'erreur
      
    }
    
    // Fermer la session après peut etre ? 
    
    }
    
    public function action_form_signup(){
        $m = Model::getModel();
        $data = []; 

        $this->render("signup", $data);
    }

    public function action_signup(){

        // Récupérer les infos via l'URL 
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $username = $_POST['etud_num'];
        // TODO: Faire hashpassword truc
        $password = $_POST['password'];

        // Vérifie la connexion à la base de données
    
    
    
    
        // Vérifie si les informations de l'utilisateur sont valides
        if (empty($prenom) ||empty($nom) ||empty($username) || empty($password) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {    
            // Affiche un message d'erreur
            echo "Informations de l'utilisateur non valides";
        }
        else{
    
            // Requête SQL pour vérifier si l'utilisateur existe déjà dans la base de données
            $req = $this->bd->prepare('SELECT * FROM client WHERE username= :username OR email= :email');
            $req->bindValue(':username',$username);
            $req->bindValue(':email',$email);
            $nb = $req->rowCount();
    
    
            // Vérifie si l'utilisateur existe déjà dans la base de données
            if($nb>0){
                //Message d'erreur car il existe déjà un utilisateur avec ces informations 
                // TODO: le message d'erreur
                $this->action_error("Message erreur");
            }
            else{
                // Requête SQL pour insérer le client dans la base de données authentification afin qu'il puisse se connecter par la suite sans problèmes 
                $req2 = $this->bd->prepare("INSERT INTO Authentification (num_etudiant,password) VALUES ('$username','$password')");
                // TODO Marqueur de place et exécution puis return

                // Requête SQL pour insérer l'utilisateur dans la base de données des clients 
                $requete = $this->bd->prepare("INSERT INTO Client (nom,prenom,email,num_etudiant) VALUES ('$nom','$prenom','$email','$username')");
    
                
                // Possibilité d'ajouter un message pour savoir si l'insertion à réussi 
    
            }
    
        } 
    
        // Fermer la connexion à la base de données ? 
        
    }

    public function action_oublimdp(){

    }


    public function action_default(){
        $this->action_form_login();
    }

}
?>