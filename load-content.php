<?php
require_once 'PuntenDataHandler.php';
require_once 'PersonenDataHandler.php';
require_once 'ModulesDataHandler.php';

$puntenHandler = new PuntenDataHandler();
$persoonHandler = new PersonenDataHandler();
$moduleHandler = new ModulesDataHandler();

$type = $_GET['type'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($type === 'student') {
    $persoon = $persoonHandler->getPersoonById($id);
    $punten = $puntenHandler->getPuntenByPersoonId($id);

    echo "<div class='card'>";
    echo "<h2>" . htmlspecialchars($persoon->getVoornaam() . ' ' . $persoon->getFamilienaam()) . "</h2>";
    echo "<table><thead><tr><th>Module</th><th>Punt</th></tr></thead><tbody>";
    foreach ($punten as $punt) {
        echo "<tr><td>" . htmlspecialchars($punt->getModuleNaam()) . "</td><td>" . $punt->getPunt() . "</td></tr>";
    }
    echo "</tbody></table></div>";

} elseif ($type === 'module') {
    $punten = $puntenHandler->getPuntenByModuleId($id);
    $module = $moduleHandler->getModuleById($id);

    echo "<div class='card'>";
    echo "<h2>" . htmlspecialchars($module->getNaam()) . "</h2>";
    echo "<table><thead><tr><th>Student</th><th>Punt</th></tr></thead><tbody>";
    foreach ($punten as $p) {
        echo "<tr><td>" . htmlspecialchars($p['student']) . "</td><td>" . $p['punt'] . "</td></tr>";
    }
    echo "</tbody></table></div>";
}
