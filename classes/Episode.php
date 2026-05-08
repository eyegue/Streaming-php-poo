<?php

class Episode
{
    private int $numero;
    private string $titre;
    private string $description;
    private int $duree;
    private DateTime $dateDiffusion;

    public function __construct(int $numero, string $titre, string $description, int $duree, DateTime $dateDiffusion)
    {
        if ($numero <= 0) {
            throw new Exception("Le numero d'episode doit etre superieur a 0.");
        }

        if ($duree <= 0) {
            throw new Exception("La duree d'un episode doit etre superieure a 0.");
        }

        $this->numero = $numero;
        $this->titre = trim($titre);
        $this->description = trim($description);
        $this->duree = $duree;
        $this->dateDiffusion = $dateDiffusion;
    }

    public function getNumero(): int
    {
        return $this->numero;
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

    public function getDateDiffusion(): DateTime
    {
        return $this->dateDiffusion;
    }

    public function formaterDuree(): string
    {
        return "{$this->duree}min";
    }

    public function afficherResume(): string
    {
        $titre = htmlspecialchars($this->titre, ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $date = $this->dateDiffusion->format('d/m/Y');

        return "
            <li>
                <strong>Episode {$this->numero} - {$titre}</strong>
                <span>{$this->formaterDuree()} - {$date}</span>
                <p>{$description}</p>
            </li>
        ";
    }
}
