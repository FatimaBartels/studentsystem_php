<?php
declare(strict_types = 1);

require_once 'PersonenDataHandler.php';
require_once 'ModulesDataHandler.php';

$persoonList = new PersonenDataHandler();
$personen = $persoonList->getPersonenList();

$moduleList = new ModulesDataHandler();
$modules = $moduleList->getModulesList();

session_start();
?>

<h2>Punt toevoegen</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p class="success-message"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="add-punt.php" method="post" class="punt-form">
    <div class="form-group">
            <label for="student">Student:</label>
            <select id="student" name="persoonId"  required>
                <option value="">.. Kies Student ..</option>
                <?php foreach ($personen as $persoon): ?>
                    <option value="<?= $persoon->getId(); ?>">
                        <?= $persoon->getFamilienaam(); ?> <?= $persoon->getVoornaam(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <div class="form-group">
        <label for="module">Module:</label>
        <select id="module" name="moduleId"  required>
            <option value="">.. Kies Module ..</option>
            <?php foreach ($modules as $module): ?>
                <option value="<?= $module->getId(); ?>"><?= $module->getNaam(); ?></option>
            <?php endforeach; ?>
        </select>
    </div> 
    <div class="form-group">
        <label for="punt">Punt:</label>
        <input type="number" name="punt" id="punt" min="0" max="100" required />
    </div>

    <button type="submit" class="btn">Opslaan</button>
</form>


