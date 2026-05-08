<?php

abstract class Video
{
    protected string $id;
    protected string $titre;
    protected string $description;
    protected int $duree;
    protected int $anneePublication;
    protected string $realisateur;
    protected string $genre;
    protected float $notation;
    protected string $urlAffiche;
    protected DateTime $dateAjout;

    public const GENRES = ["Action", "Comedie", "Horreur", "Drame", "Science-fiction", "Animation", "Documentaire"];

    public function __construct(
        string $id,
        string $titre,
        string $description,
        int $duree,
        int $anneePublication,
        string $realisateur,
        string $genre,
        float $notation,
        string $urlAffiche
    ) {
        $this->id = trim($id);
        $this->titre = trim($titre);
        $this->description = trim($description);
        $this->setDuree($duree);
        $this->setAnneePublication($anneePublication);
        $this->realisateur = trim($realisateur);
        $this->setGenre($genre);
        $this->setNotation($notation);
        $this->urlAffiche = trim($urlAffiche);
        $this->dateAjout = new DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDuree(): int
    {
        return $this->duree;
    }

    public function getAnneePublication(): int
    {
        return $this->anneePublication;
    }

    public function getRealisateur(): string
    {
        return $this->realisateur;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getNotation(): float
    {
        return $this->notation;
    }

    public function getUrlAffiche(): string
    {
        return $this->urlAffiche;
    }

    public function getDateAjout(): DateTime
    {
        return $this->dateAjout;
    }

    public function setDuree(int $duree): void
    {
        if ($duree <= 0) {
            throw new Exception("La duree doit etre superieure a 0.");
        }

        $this->duree = $duree;
    }

    public function setAnneePublication(int $anneePublication): void
    {
        $anneeCourante = (int) date('Y') + 2;

        if ($anneePublication < 1888 || $anneePublication > $anneeCourante) {
            throw new Exception("L'annee de publication est invalide.");
        }

        $this->anneePublication = $anneePublication;
    }

    public function setNotation(float $notation): void
    {
        if ($notation < 0 || $notation > 5) {
            throw new Exception("La notation doit etre entre 0 et 5.");
        }

        $this->notation = $notation;
    }

    public function setGenre(string $genre): void
    {
        if (!in_array($genre, self::GENRES, true)) {
            throw new Exception("Genre non autorise.");
        }

        $this->genre = $genre;
    }

    public function formaterDuree(): string
    {
        if ($this->duree >= 60) {
            $heures = floor($this->duree / 60);
            $minutes = $this->duree % 60;

            return $minutes > 0 ? "{$heures}h{$minutes}" : "{$heures}h";
        }

        return "{$this->duree}min";
    }

    abstract public function afficherDetails(): string;

    abstract public function getType(): string;

    protected function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
