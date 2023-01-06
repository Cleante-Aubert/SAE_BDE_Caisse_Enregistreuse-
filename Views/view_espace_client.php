<?php require "view_begin.php"; ?>

<h1>Bonjour, espace client de <?=e($nomprenom)?></h1>

<!-- DEBUG-->
<ul>
    <?php foreach ($_SESSION as $c=>$v): ?>
        <li><?=e($c)?> = <?=e($v)?></li>
    <?php endforeach ?>
</ul>

<h2>Historique des achats</h2>

<?php foreach ($historique as $date=>$ligne): ?>
    <h3><?=e($date)?></h3>
    <table>
        <tr>
            <?php foreach ($ligne[0] as $c=>$v): ?>
                <th><?=e($c)?></th>
            <?php endforeach ?>
        </tr>
        <?php foreach ($ligne as $sous_ligne): ?>
        <tr>
            <?php foreach ($sous_ligne as $v): ?>
                <td><?=e($v)?></td>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>
    </table>
<?php endforeach ?>

<?php require "view_end.php";?>