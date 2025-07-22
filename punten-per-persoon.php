<?php
declare(strict_types=1);



require_once 'PuntenDataHandler.php';
require_once 'PersonenDataHandler.php';

$puntenHandler = new PuntenDataHandler();
$persoonHandler = new PersonenDataHandler();

if (!isset($_GET['persoonId']) || !is_numeric($_GET['persoonId'])) {
    die("Ongeldig persoon ID.");
}

$persoonId = (int)$_GET['persoonId'];
$persoon = $persoonHandler->getPersoonById($persoonId);

if (!$persoon) {
    die("Student niet gevonden.");
}

$punten = $puntenHandler->getPuntenByPersoonId($persoonId);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Punten per Student</title>
</head>
<body>

    <div >
        <h2>Student: <?= htmlspecialchars($persoon->getFamilienaam()) ?> <?= htmlspecialchars($persoon->getVoornaam()) ?></h2>
    <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Punt</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($punten as $punt): ?>
                    <tr>
                        <td><?= htmlspecialchars($punt->getModuleNaam()) ?></td>
                        <td><?= (int)$punt->getPunt() ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    
    </div>
</body>
</html>