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

$punten = $puntenHandler->getPuntenByModuleId($moduleId);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Punten per Module</title>
</head>
<body>

    <div class="container">
    <h2>Module: <?= htmlspecialchars($module->getNaam()) ?></h2>

    <table border="1">
        <thead>
            <tr>
                <th>Student</th>
                <th>Punt</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($punten as $punt): ?>
            <tr>
                <td><?= htmlspecialchars($punt['student']) ?></td>
                <td><?= (int)$punt['punt'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>
</html>