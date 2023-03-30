<?php
error_reporting(E_ERROR | E_PARSE);
$db = new PDO('mysql:host=localhost;dbname=poo_sgbd;port=3306;charset=utf8', 'root', '');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
<body>


<?php



include ('Personnage.php');
//include('Guerrisseur.php');
//include ('Guerrier.php');

include('personnageManager.php');
$manager= new personnageManager($db);
$persos = $manager->getList();
//var_dump($persos);
?>
<div class="part1">
  <form method="post" action="">
    <h4>Ajouter un personnage</h4>

    <div class="">
      <label for="name">name</label>
      <input id="name" class="input" type="text" name="name"/>
    </div>

    <div class="">
      <label for="atk">atk</label>
      <input id="atk" class="input" type="text" name="atk"/>
    </div>

    <div class="">
      <label for="pv">pv</label>
      <input id="pv" class="input" type="text" name="pv"/>
    </div>

    <button type="text" name="ajoutPerso" class="submit">Ajouter</button>
  </form>


  <form method="post" action="">
    <h4>Supprimer un personnage</h4>

  <?php
    $stmt = $db->query("SELECT name FROM personnage");
    $stmt->execute();
    $row = $stmt->fetchAll();
  ?>

    <div class="">
      <select name="personnage" id="" class="select">
      <?php foreach ($row as $names) { ?>
          <option value="<?php if (isset($_POST["personnage"])) { echo $_POST["personnage"]; } else { echo $names[0]; } ?>"><?php echo $names[0] ?></option>
      <?php } ?>
      </select>
    </div>

    <button type="text" class="submit" id="supprimer" name="supprimer">Supprimer</button>
  </form>

  <?php
  if (isset ($_POST['ajoutPerso'])){
    $new_perso = new Personnage($_POST);
    $manager->ajoutPerso($new_perso);
  }
  if (isset ($_POST['supprimer'])){
    $manager->suppPerso($_POST["personnage"]);
  }
  
  if (isset($_POST["relancer"])) {
    $db->query("DELETE FROM personnage WHERE pv<1");
  }
  ?>


    <form action="" method="post">
      <h4>Changez les stats</h4>    
      <label for="personnage">perso</label>
      <select name="personnage" id="personnage" class="select">
        <option>Choisir un perso</option>
      <?php foreach ($row as $names) { ?>
        <option value="<?php echo $names[0] ?>"><?php echo $names[0] ?></option>
      <?php } ?>
      </select>
      <br>
      <label for="atk">atk</label>
      <input id="atk" class="input" type="text" name="atk"/>
      <br>
      <label for="pv">pv</label>
      <input id="pv" class="input" type="text" name="pv"/>
      <button type="text" class="submit" id="confirmer" name="confirmer">Confirmer</button>
    </form>
  <?php
  if(isset($_POST['confirmer'])) {
    $manager->modifPerso($_POST["personnage"], $_POST["pv"], $_POST["atk"]);
  }
  ?>

  <div class="perso1">
    <form action="" method="post">
    
      
    </form>

  </div>

</div>

<form action="" method="post">
<h4>Choisir les combattants</h4>
  <div class="part2">
    <div class="select1">
      <select name="choisir-perso1" id="choisir-perso1" class="select">
        <option>Choisir un perso</option>
        <?php foreach ($row as $names) { ?>
          <option <?php if ($_POST['choisir-perso1'] == $names[0]) { ?>selected="true" <?php }; ?>value="<?php echo $names[0] ?>"><?php echo $names[0] ?></option>
        <?php } ?>
      </select>
      <button type="text" class="submit" id="regenerer-perso1" name="regenerer-perso1">Regenerer</button>
    </div>  

    <div class="select2">
      <select name="choisir-perso2" id="choisir-perso2" class="select">
        <option>Choisir un perso</option>
        <?php foreach ($row as $names) { ?>
          <option <?php if ($_POST['choisir-perso2'] == $names[0]) { ?>selected="true" <?php }; ?>value="<?php echo $names[0] ?>"><?php echo $names[0] ?></option>
        <?php } ?>
      </select>
      <button type="text" class="submit" id="regenerer-perso1" name="regenerer-perso2">Regenerer</button>
    </div>  

    <div class="bouton">
      <button type="text" class="submit" id="selectionner" name="selectionner">Sélectionner</button>
      <button type="text" class="submit" id="attaquer" name="attaquer">Attaquer</button>
    </div>
      
  </div>
  </form>

<div class="texte">
  <?php
  if(isset($_POST['selectionner'])) {
    //$manager->choisirPerso($_POST["choisir-perso2"]);
    //$manager->choisirPerso($_POST["choisir-perso1"]);
    $manager -> getPerso($_POST["choisir-perso1"]);
    $manager -> getPerso($_POST["choisir-perso2"]);
  }
  ?>

  <?php
  if (isset($_POST['attaquer'])) {
    $manager->atkPerso($_POST["choisir-perso1"], $_POST["choisir-perso2"]);
    $manager->atkPerso($_POST["choisir-perso2"], $_POST["choisir-perso1"]);
    
  }
  ?>
</div>

  <?php
  if (isset($_POST['regenerer-perso1'])) {
    $manager->regenerer($_POST["choisir-perso1"]);  
  }
  if (isset($_POST['regenerer-perso2'])) {
    $manager->regenerer($_POST["choisir-perso2"]);  
  }
  ?>

</body>
</html>
