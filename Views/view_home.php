<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<link rel="stylesheet" type="text/css" href="Content/css/home.css">


        <section class="banniere_accueil">
            <div class="phrase_bienvenue">
                <h1>Bienvenue au stand de confiseries du Wolf BDE !</h1>
            </div>
        </section>

        <!-- Produits populaires -->
        <!--
          TODO Pour l'instant en format table,
          adapter à un format "carte produit"
          genre un petit bloc carré jsp
        -->
        <section class="produits_du_moment">
            <h4>Nos produits du moment</h4>
            <div class="liste_produits_actuels">
            <?php foreach ($popular_prod as $ligne): ?>
              <ul>
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li class="prix"><?=e($ligne["Prix"])?> €</li>
              </ul>
            <?php endforeach ?>
            </div>

        </section>

        <section class="produits_nouveautes">
            <h4>Nos nouveautés</h4>
            <div class="liste_produits_nouveautes">
            <?php foreach ($nouv_prod as $ligne): ?>
              <ul>
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li class="prix"><?=e($ligne["Prix"])?> €</li>
              </ul>
            <?php endforeach ?>
            </div>

        </section>

        <section class="bde_presentation">
            <div>
                <h4>Le Wolf BDE</h4>
            </div>
            <p class="description">
              Le Wolf BDE, aussi connu sous le nom de Bureau Des Etudiants (BDE) de l'IUT de Villetaneuse, 
              est une association au profit des étudiants, géré par des étudiants, 
              afin de leur permettre un épanouissement extrascolaire. 
              Nous possédons un espace de détente avec plein d'activités, des jeux de société, des sièges de repos, 
              un piano, un micro-onde et bien évidemment, notre propre stand de confiseries !
            </p>
            <h1 id="invitation">Rendez-vous en salle Q101 !</h1>
        </section>
        </main>

<?php require "view_end.php";?>