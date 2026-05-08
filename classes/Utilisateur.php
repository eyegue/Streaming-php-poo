<?php

class Utilisateur
{
    private string $nom;
    private string $email;

    /** @var Playlist[] */
    private array $playlists = [];

    public function __construct(string $nom, string $email)
    {
        $nom = trim($nom);
        $email = trim($email);

        if ($nom === '') {
            throw new Exception("Le nom de l'utilisateur est obligatoire.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'adresse email est invalide.");
        }

        $this->nom = $nom;
        $this->email = $email;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function ajouterPlaylist(Playlist $playlist): void
    {
        $this->playlists[$playlist->getNom()] = $playlist;
    }

    /**
     * @return Playlist[]
     */
    public function getPlaylists(): array
    {
        return array_values($this->playlists);
    }
}
