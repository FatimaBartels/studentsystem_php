<?php

declare(strict_types = 1);

//add-Punt.php

require_once 'Punt.php';
require_once 'PuntenDataHandler.php';

if (isset($_POST, $_POST['punt'], $_POST['moduleId'], $_POST['persoonId']) &&
    !empty($_POST['punt']) &&
    !empty($_POST['moduleId'])  &&
    !empty($_POST['persoonId'])
) {
    session_start();

    $punt = (int)$_POST['punt'];
    $moduleId = (int)$_POST['moduleId'];
    $persoonId = (int)$_POST['persoonId'];
    
    if (is_numeric($punt) && $punt >= 0 && $punt <= 100 ) {
        $puntlist = new PuntenDataHandler();
   
       
        if (!$puntlist->puntToegevoegd($persoonId, $moduleId)) {
            $puntObj = Punt::create($moduleId, $persoonId, $punt);
            $puntlist->addPunt($puntObj);
            $_SESSION['success'] = "Punt is toegevoegd.";
        } else {
            $_SESSION['error'] = "Dit persoon heeft al een punt voor dit module .";
        }
    } else {
        $_SESSION['error'] = "Punt moet tussen 0 en 100.";
    }
}

header("Location: index.php?form=addPunt");
exit;
