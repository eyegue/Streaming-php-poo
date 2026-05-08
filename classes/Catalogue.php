<?php

class Catalogue
{
    /** @var Video[] */
    private array $videos = [];

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

    /**
     * @return Video[]
     */
    public function rechercher(string $terme): array
    {
        $terme = strtolower(trim($terme));

        if ($terme === '') {
            return $this->getVideos();
        }

        return array_values(array_filter($this->videos, function (Video $video) use ($terme): bool {
            return str_contains(strtolower($video->getTitre()), $terme)
                || str_contains(strtolower($video->getGenre()), $terme)
                || str_contains(strtolower($video->getDescription()), $terme);
        }));
    }

    /**
     * @return Video[]
     */
    public function filtrerParGenre(string $genre): array
    {
        if ($genre === '') {
            return $this->getVideos();
        }

        return array_values(array_filter($this->videos, fn (Video $video): bool => $video->getGenre() === $genre));
    }

    public function trouverParId(string $id): ?Video
    {
        return $this->videos[$id] ?? null;
    }
}
