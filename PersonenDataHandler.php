<?php

require_once "Persoon.php";

class PersonenDataHandler
{
    private ?PDO $dbh = null;

    public function getPersonenList(): array
    {
        $this->connect();

        $stmt = $this->dbh->prepare(
            "select id, familienaam, voornaam, geslacht from personen;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();

        $resultPersoon = [];
        foreach ($data as $persoon) {
            $resultPersoon [] = Persoon::create(
                $persoon['familienaam'],
                $persoon['voornaam'],
                $persoon['geslacht'],
                (int)$persoon['id']
            );
        }

        return $resultPersoon;
    }

    public function getPersoonById(int $id): ? Persoon {
        $this->connect();
        $stmt = $this->dbh->prepare("SELECT * FROM personen WHERE id = :id");
        $stmt->execute([':id' => $id]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->disconnect();
    
        if ($row) {
            return Persoon::create(
                $row['familienaam'],
                $row['voornaam'],
                $row['geslacht'],
                (int)$row['id']
            );
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