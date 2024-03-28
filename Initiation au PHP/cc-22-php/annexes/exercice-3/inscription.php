<?php
  $club_exclus = ['CDK85', 'ASRennes', 'ABC89', 'AKA95'];
  $categorie_age = [
    'benjamin' => [10,11],
    'minime'   => [12,13],
    'cadet'    => [14,15],
    'junior'   => [16,17],
    'senior'   => range(18,35)
  ];

  // A COMPLETER --------------------------------------------
  if(isset($_POST['submit'])){
    $nom= isset($_POST['nom']) ? strtoupper($_POST['nom']) : '';
    $prenom=isset($_POST['prenom']) ? ucfirst($_POST['nom']) : '';
    $age=isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $categorie=isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $club=isset($_POST['club']) ? $_POST['club'] : '';

    
  }
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eeeeee;
    }
    fieldset {
        padding: 20px 10px 10px 20px;
    }
    input,
    select {
      margin-bottom: 10px;
    }
    legend,
    input[type="submit"] {
      font-weight: bold;
    }
    .ok {
      color: green;
    }
    .error {
      color: red;
    }
  </style>
  <title>Exercice 3 - Formulaires</title>
</head>

<body>
  <!-- A COMPLETER -------------------------------------------->
  <form action="" method="POST">
    <fieldset>
      <legend>Inscription compétiteur</legend>
      <label for="nom">Nom: </label>
      <input type="text" name="nom" id="nom" value=""/>
      <br />
      <label for="nom">Prénom: </label>
      <input type="text" name="prenom" id="prenom" value=""/>
      <br />
      <label for="nom">Age: </label>
      <input type="number" name="age" id="age" value=""/>
      <br />
      <label for="categorie">Catégorie: </label>
      <select name="categorie" id="categorie">
        <option value="benjamin">Benjamin</option>
        <option value="minime">Minime</option>
        <option value="cadet">Cadet</option>
        <option value="junior">Junior</option>
        <option value="senior">Sénior</option>
      </select>
      <br />
      <label for="club">Club: </label>
      <input type="text" name="club" id="club" />
      <br />
      <input type="submit" name="submit" value="Inscrire" />
    </fieldset>
  </form>

    <div id="messages">
      <?php
       $erreur_categorie_age=false;
       if(array_key_exists($categorie, $categorie_age)){
         $age_min=min($categorie_age[$categorie]);
         $age_max=max($categorie_age[$categorie]);
         if($age < $age_min || $age > $age_max){
           $erreur_categorie_age=true;
         }
       }else $erreur_categorie_age=true;
   
       $erreur_club=false;
       if(in_array($club,$club_exclus)){
         $erreur_club=true;
       }
       echo '<p class="';
       if((!$erreur_categorie_age && !$erreur_club)){
         echo 'ok"> competiteur inscrit(e) : '. $nom . ' ,'. $prenom . '</p>';
       }else {
         echo 'error">Compétiteur non inscrit. Erreur : ';
         if ($erreur_categorie_age) {
             echo 'L’age indiqué ne correspond pas à la catégorie demandée. ';
         }
         if ($erreur_club) {
             echo 'Le club ' . $club . ' ne participe pas à cette compétition.';
         }
         echo '</p>';
       }
       // A COMPLETER --------------------------------------------
      ?>
    </div>
  </body>
</html>