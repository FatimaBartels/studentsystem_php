<?php
// Class Punt.php

require_once "Persoon.php";
require_once "Module.php";



class Punt
{
    private ?int $moduleId;
    private ?int $persoonId;
    private ?int $punt;

    private ?PDO $dbh = null;
    

    public function __construct(?int $moduleId, ?int $persoonId, ?int $punt)
    {
        $this->moduleId    = $moduleId;
        $this->persoonId= $persoonId;
        $this->punt  = $punt;
       
       
       
    }

    public static function create(
    ?int $moduleId, ?int $persoonId, ?int $punt
        ): Punt

    {
        return new Punt($moduleId, $persoonId, $punt);
    }

    

    public function getModuleId(): ?int
    {
        return $this->moduleId;
    }

    public function getPersoonId(): ?int
    {
        return $this->persoonId;
    }

    public function getPunt(): ?int
    {
        return $this->punt;
    }


   public function getPersoon() {
    
    $this->connect();

  
    $stmt = $this->dbh->prepare("SELECT * FROM personen WHERE id = :id");

    $stmt->execute([':id' => $this->persoonId]);

    $persoonResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$persoonResult) {
        $this->disconnect();
        return new Persoon("Onbekend", "Onbekend", "X", 0);
    }

    $persoon = new Persoon(
    $persoonResult["familienaam"],
    $persoonResult["voornaam"], 
    $persoonResult["geslacht"],
    $persoonResult["id"]
    
    );

    $this->disconnect();
    return $persoon;
    }
     
    
    public function getModule() {

        $this->connect();

        $stmt = $this->dbh->prepare("SELECT * FROM modules WHERE id = :id");
    
        $stmt->execute([':id' => $this->moduleId]);

        $moduleResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$moduleResult) {
        $this->disconnect();
        return new Module(0, "Onbekend");
    }

      
        $module = new Module(
        $moduleResult["id"],
        $moduleResult["naam"]
        
        );

        $this->disconnect();

        return $module;
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
