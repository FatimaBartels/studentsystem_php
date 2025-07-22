<?php
require_once 'PersonenDataHandler.php';
require_once 'ModulesDataHandler.php';

$persoonHandler = new PersonenDataHandler();
$moduleHandler = new ModulesDataHandler();

$studenten = $persoonHandler->getPersonenList();
$modules = $moduleHandler->getModulesList();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/style.css">

  <title>Studenten Systeem</title>
</head>
<body>
<div class="container">

  <div class="sidebar">
    <h2>STUDENTEN</h2>
    <ul>
      <?php foreach ($studenten as $s): ?>
        <li>
          <a href="?persoonId=<?= $s->getId() ?>">
            <?= htmlspecialchars($s->getVoornaam() . ' ' . $s->getFamilienaam()) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <h2>MODULES</h2>
    <ul>
      <?php foreach ($modules as $m): ?>
        <li>
          <a href="?moduleId=<?= $m->getId() ?>">
            <?= htmlspecialchars($m->getNaam()) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <h2>ACTIES</h2>
    <ul>
      <li><a href="?form=addPunt">Punt toevoegen</a></li>
    </ul>
  </div>

  <div class="content" id="main-content">
    <div class="card">
      <?php
      if (isset($_GET['persoonId'])) {
          include 'punten-per-persoon.php';
      } elseif (isset($_GET['moduleId'])) {
          include 'punten-per-module.php';
      } elseif (isset($_GET['form']) && $_GET['form'] === 'addPunt') {
          include 'punt-form.php';
      } else {
          echo "<h2>Selecteer een student, module of actie</h2>";
      }
      ?>
    </div>
  </div>

</div>
</body>
</html>
