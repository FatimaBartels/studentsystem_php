<?php

require_once "Module.php";

class ModulesDataHandler
{
    private ?PDO $dbh = null;

    public function getModulesList(): array
    {

        $this->connect();
        $stmt = $this->dbh->prepare(
            "select id, naam from modules;"
        );

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();

        $resultModule = [];
        foreach ($data as $row) {
            $resultModule[] = Module::create(
                (int)$row['id'], 
                $row['naam']
            );



        }

        return $resultModule;
    }

    public function getModuleById(int $id): ?Module {
        $this->connect();
        $stmt = $this->dbh->prepare("SELECT * FROM modules WHERE id = :id");
        $stmt->execute([':id' => $id]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->disconnect();
    
        if ($row) {
            return Module::create((int)$row['id'], $row['naam']);
        }
    
        return null;
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