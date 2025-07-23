<?php
declare(strict_types=1);

require_once 'PuntenDataHandler.php';
require_once 'ModulesDataHandler.php';

$puntenHandler = new PuntenDataHandler();
$moduleHandler = new ModulesDataHandler();

if (!isset($_GET['moduleId']) || !is_numeric($_GET['moduleId'])) {
    die("Ongeldig module ID.");
}

$moduleId = (int)$_GET['moduleId'];
$module = $moduleHandler->getModuleById($moduleId);

if (!$module) {
    die("Module niet gevonden.");
}


$punten = $puntenHandler->getPuntenVoorModule($moduleId);

?>

<link rel="stylesheet" href="css/style.css">
<div>
    <h2>Module: <?= $module->getNaam() ?> </h2>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Punt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($punten as $punt): ?> 
                    <tr>
                        <td><?= $punt->getPersoon()->getFamilienaam() ?> <?= $punt->getPersoon()->getVoornaam() ?> </td>
                        <td><?= $punt->getPunt() ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
