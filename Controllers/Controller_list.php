<?php

class Controller_list extends Controller{

  public function action_produits() {
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();
    $data =
      [
        "produits" => $m->getProduits($filter)
      ];

    $this->render("produits", $data);
  }

  public function action_confiseries() {
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();
    $data =
      [
        "produits" => $m->getProduits($filter, "food", "default")
      ];

    $this->render("produits_confiseries", $data);
  }

  public function action_boissons() {
    //--------------------------------------------------------
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $data =
      [
        "boissons" => $m->getProduits($filter, "boisson", "default"),
        "sodas" => $m->getProduits($filter, "soda", "default"),
        "sirops" => $m->getProduits($filter, "sirop", "default")
      ];

    $this->render("produits_boissons", $data);
    /* ============================ANCIEN CODE======================
    non utilisé car changement de disposition html, emploi de javascript 
    (plus pratique, voir dans vue view_produits_boissons.php pour plus de détail)
    ================================================================
    // type de boissons recherchés
    // on définit par défaut type = drink pour toutes les boissons
    $type = "drink";

    //--------------------------------------------------------
    // si on veut que les sodas, on se basera sur les paramètres de l'url
    if (isset($_GET["type"])) {
      // étant donné que les catégories dans la bd ont une majuscule au début
      $type = ucfirst(e($_GET["type"]));
    }
    //--------------------------------------------------------
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $data =
      [
        "produits" => $m->getProduits($filter, $type, "default")
      ];

    $this->render("produits_boissons", $data);
    */
  }

  public function action_gestion_clients(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un admin
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $colonnes = $m->getClients();
    $colonnes = array_keys($colonnes[0]);
    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Gestion des comptes clients",
        "listed_elements" => "gestion_clients",
        "id_element" => "id_client",
        "colonnes" => $colonnes,
        "liste" => $m->getClients($search)
      ];

    $this->render("list", $data);
  }

  public function action_gestion_admins(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un super-admin
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $colonnes = $m->getAdmins();
    $colonnes = array_keys($colonnes[0]);
    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Gestion des comptes administrateurs",
        "listed_elements" => "gestion_admins",
        "id_element" => "id_admin",
        "colonnes" => $colonnes,
        "liste" => $m->getAdmins($search)
      ];

    $this->render("list", $data);
  }

  public function action_gestion_ventes(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un super-admin
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $colonnes = $m->getHistoriqueAchats();
    $colonnes = array_keys($colonnes[0]);
    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Historique des ventes du stand",
        "listed_elements" => "gestion_ventes",
        "id_element" => "num_vente",
        "colonnes" => $colonnes,
        "liste" => $m->getHistoriqueAchats($search)
      ];

    $this->render("list", $data);
  }

  public function action_gestion_inventaire(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un super-admin
    // TODO: pour Alex H., changer l'ordre des attributs pour qu'on ait les images des produits d'abord? ici ou dans view_list
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    /*
    $colonnes = $m->getProduits();
    $colonnes = array_keys($colonnes[0]);
    */
    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Inventaire des produits du stand",
        "listed_elements" => "gestion_inventaire",
        "id_element" => "id_produit",
        "colonnes" => ["Identifiant", "Image", "Nom du produit", "Catégorie", "Prix", "Date d'ajout", "En stock", "Vendus"],
        "liste" => $m->getProduits("default","default",$search)
      ];

    $this->render("list", $data);
  }
  
  public function action_default(){
    $this->action_produits();
  }

}
?>
