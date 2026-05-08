<?php

class Film extends Video
{
    private float $budget;
    private float $boxOffice;
    private string $langueOriginale;

    public function __construct(
        string $id,
        string $titre,
        string $description,
        int $duree,
        int $anneePublication,
        string $realisateur,
        string $genre,
        float $notation,
        string $urlAffiche,
        float $budget,
        float $boxOffice,
        string $langueOriginale
    ) {
        parent::__construct($id, $titre, $description, $duree, $anneePublication, $realisateur, $genre, $notation, $urlAffiche);
        $this->setBudget($budget);
        $this->setBoxOffice($boxOffice);
        $this->setLangueOriginale($langueOriginale);
    }

    public function getBudget(): float
    {
        return $this->budget;
    }

    public function getBoxOffice(): float
    {
        return $this->boxOffice;
    }

    public function getLangueOriginale(): string
    {
        return $this->langueOriginale;
    }

    public function setBudget(float $budget): void
    {
        if ($budget < 0) {
            throw new Exception("Le budget ne peut pas etre negatif.");
        }

        $this->budget = $budget;
    }

    public function setBoxOffice(float $boxOffice): void
    {
        if ($boxOffice < 0) {
            throw new Exception("Le box-office ne peut pas etre negatif.");
        }

        $this->boxOffice = $boxOffice;
    }

    public function setLangueOriginale(string $langueOriginale): void
    {
        $langueOriginale = trim($langueOriginale);

        if ($langueOriginale === '') {
            throw new Exception("La langue originale ne peut pas etre vide.");
        }

        $this->langueOriginale = $langueOriginale;
    }

    public function calculerRentabilite(): float
    {
        if ($this->budget === 0.0) {
            return 0.0;
        }

        return (($this->boxOffice - $this->budget) / $this->budget) * 100;
    }

    public function getType(): string
    {
        return "Film";
    }

    public function afficherDetails(): string
    {
        $rentabilite = number_format($this->calculerRentabilite(), 2);
        $budget = number_format($this->budget, 0, ',', ' ');
        $boxOffice = number_format($this->boxOffice, 0, ',', ' ');

        return "
            <p><strong>Duree :</strong> {$this->formaterDuree()}</p>
            <p><strong>Annee :</strong> {$this->anneePublication}</p>
            <p><strong>Realisateur :</strong> {$this->e($this->realisateur)}</p>
            <p><strong>Langue originale :</strong> {$this->e($this->langueOriginale)}</p>
            <p><strong>Budget :</strong> {$budget} EUR</p>
            <p><strong>Box-office :</strong> {$boxOffice} EUR</p>
            <p><strong>Rentabilite :</strong> {$rentabilite}%</p>
        ";
    }
}
