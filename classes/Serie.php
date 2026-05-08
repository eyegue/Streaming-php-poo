<?php

class Serie extends Video
{
    private int $nombreSaisons;

    /** @var Episode[] */
    private array $episodes = [];

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
        int $nombreSaisons
    ) {
        parent::__construct($id, $titre, $description, $duree, $anneePublication, $realisateur, $genre, $notation, $urlAffiche);
        $this->setNombreSaisons($nombreSaisons);
    }

    public function setNombreSaisons(int $nombreSaisons): void
    {
        if ($nombreSaisons <= 0) {
            throw new Exception("Une serie doit avoir au moins une saison.");
        }

        $this->nombreSaisons = $nombreSaisons;
    }

    public function ajouterEpisode(Episode $episode): void
    {
        $this->episodes[] = $episode;
    }

    /**
     * @return Episode[]
     */
    public function getEpisodes(): array
    {
        return $this->episodes;
    }

    public function getNombreEpisodes(): int
    {
        return count($this->episodes);
    }

    public function getType(): string
    {
        return "Serie";
    }

    public function afficherDetails(): string
    {
        $episodes = '';

        foreach ($this->episodes as $episode) {
            $episodes .= $episode->afficherResume();
        }

        if ($episodes === '') {
            $episodes = '<li>Aucun episode disponible.</li>';
        }

        return "
            <p><strong>Duree moyenne :</strong> {$this->formaterDuree()}</p>
            <p><strong>Annee :</strong> {$this->anneePublication}</p>
            <p><strong>Createur :</strong> {$this->e($this->realisateur)}</p>
            <p><strong>Saisons :</strong> {$this->nombreSaisons}</p>
            <p><strong>Episodes :</strong> {$this->getNombreEpisodes()}</p>
            <ul class=\"episodes\">{$episodes}</ul>
        ";
    }
}
