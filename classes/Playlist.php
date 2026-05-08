<?php

class Playlist
{
    private string $nom;

    /** @var Video[] */
    private array $videos = [];

    public function __construct(string $nom)
    {
        $nom = trim($nom);

        if ($nom === '') {
            throw new Exception("Le nom de la playlist est obligatoire.");
        }

        $this->nom = $nom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function ajouterVideo(Video $video): void
    {
        $this->videos[$video->getId()] = $video;
    }

    /**
     * @return Video[]
     */
    public function getVideos(): array
    {
        return array_values($this->videos);
    }

    public function getDureeTotale(): int
    {
        return array_reduce($this->videos, fn (int $total, Video $video): int => $total + $video->getDuree(), 0);
    }
}
