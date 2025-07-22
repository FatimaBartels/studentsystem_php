<?php

require_once "Punt.php";

//PuntDataHandler.php

class PuntenDataHandler
{
    private ?PDO $dbh = null;

    public function getPuntenList(): array
    {
        $this->connect();

        $stmt = $this->dbh->prepare(
            "SELECT punten.*, 
            modules.naam AS module_naam, 
            CONCAT(personen.voornaam, ' ', personen.familienaam) AS persoon_naam
            FROM punten
            JOIN modules ON punten.moduleId = modules.id
            JOIN personen ON punten.persoonId = personen.id;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultPunt = [];
        foreach ($data as $punt) {
            $puntObj = Punt::create(
                (int)$punt['moduleId'],
                (int)$punt['persoonId'],
                (int)$punt['punt'],
                (int)$punt['id']
            );
            $puntObj->setModuleNaam($punt['module_naam']);
            $resultPunt[] = $puntObj;
        }

        return $resultPunt;
    }



    public function puntToegevoegd(int $persoonId, int $moduleId): bool {
        
        $this->connect();

        $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM punten WHERE persoonId = :persoonId AND moduleId = :moduleId");

        $stmt->execute([':persoonId' => $persoonId, ':moduleId' => $moduleId]);

        $count = $stmt->fetchColumn();

        $this->disconnect();

        return $count > 0;
    }
    


    public function addPunt(Punt $punt)
    {
        $this->connect();
        $stmt = $this->dbh->prepare(
            "INSERT INTO punten (moduleId, persoonId, punt )
                    VALUES (:moduleId, :persoonId, :punt );"
        );
    
    
        $stmt->execute(
            [
                
                ':moduleId'  => $punt->getModuleId(),
                ':persoonId' => $punt->getPersoonId(),
                ':punt'      => $punt->getPunt(),    

            ]
            );
           
            $this->disconnect();    

    }   
    
    public function getPuntenByModuleId(int $moduleId): array {
        $this->connect();
    
        $stmt = $this->dbh->prepare("
            SELECT CONCAT(personen.voornaam, ' ', personen.familienaam) AS student, punten.punt
            FROM punten
            JOIN personen ON punten.persoonId = personen.id
            WHERE punten.moduleId = :moduleId
        ");
        $stmt->execute([':moduleId' => $moduleId]);
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }
    

    public function getPuntenByPersoonId(int $persoonId): array {
        $this->connect();
    
        $stmt = $this->dbh->prepare(
            "SELECT punten.*, 
                    modules.naam AS module_naam, 
                    CONCAT(personen.voornaam, ' ', personen.familienaam) AS persoon_naam
             FROM punten
             JOIN modules ON punten.moduleId = modules.id
             JOIN personen ON punten.persoonId = personen.id
             WHERE punten.persoonId = :persoonId"
        );
    
        
        $stmt->execute([':persoonId' => $persoonId]);
    
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $this->disconnect();
    
        $result = [];
        foreach ($data as $punt) {
            $puntObj = Punt::create(
                (int)$punt['moduleId'],
                (int)$punt['persoonId'],
                (int)$punt['punt'],
                (int)$punt['id']
            );
            $puntObj->setModuleNaam($punt['module_naam']);
            $result[] = $puntObj;
        }

        return $result;
    }
    
    
    


    private function connect()
    {
        $this->dbh = new PDO(
            "mysql:host=localhost;port=3307;dbname=cursusphp;charset=utf8",
            "root",
            ''
        );
    }

    private function disconnect()
    {
        $this->dbh = null;
    }


}