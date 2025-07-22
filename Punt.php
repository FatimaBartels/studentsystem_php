<?php
// Class Punt.php

class Punt
{
    private ?int $moduleId;
    private ?int $persoonId;
    private ?int $punt;
    private ?int $id;
    private ?string $moduleNaam = null;
  

    public function __construct(?int $moduleId, ?int $persoonId, ?int $punt, ?int $id)
    {
        $this->moduleId    = $moduleId;
        $this->persoonId= $persoonId;
        $this->punt  = $punt;
        $this->id  = $id;
       
       
    }

   public static function create(
    ?int $moduleId, ?int $persoonId, ?int $punt,  ?int $id= null
        ): Punt
    {
        return new Punt($moduleId, $persoonId, $punt,  $id);
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setModuleNaam(string $moduleNaam): void {
            $this->moduleNaam = $moduleNaam;
    }

    public function getModuleNaam(): ?string {
            return $this->moduleNaam;
    }

 


}
