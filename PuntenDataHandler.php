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
            "SELECT moduleId, persoonId, punt FROM punten;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultPunt = [];
        foreach ($data as $punt) {
                $resultPunt[] = Punt::create(
                (int)$punt['moduleId'],
                (int)$punt['persoonId'],
                (int)$punt['punt']
                
            );
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
    
    /*
    public function getPuntenByModuleId(int $moduleId): array {
        $this->connect();
    
        $stmt = $this->dbh->prepare("SELECT * FROM punten WHERE moduleId = :moduleId");

        $stmt->execute([':moduleId' => $moduleId]);
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }*/
    

    public function getPuntenVoorModule(int $moduleId): array {

        $this->connect();

        $stmt = $this->dbh->prepare("SELECT moduleId, persoonId, punt FROM punten WHERE moduleId = :moduleId");
        $stmt->execute([':moduleId' => $moduleId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();

        $punten = [];
        foreach ($result as $row) {
            $punten[] = new Punt(
                (int) $row['moduleId'],
                (int) $row['persoonId'],
                (int) $row['punt']
            );
        }

        return $punten;
}


    public function getPuntenByPersoonId(int $persoonId): array {
        $this->connect();
    
        $stmt = $this->dbh->prepare(
            "SELECT * FROM punten WHERE persoonId = :persoonId"
        );
    
        
        $stmt->execute([':persoonId' => $persoonId]);
    
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $this->disconnect();
    
        $result = [];
        foreach ($data as $punt) {
            $result[] = Punt::create(
                (int)$punt['moduleId'],
                (int)$punt['persoonId'],
                (int)$punt['punt']
               
            );
           
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