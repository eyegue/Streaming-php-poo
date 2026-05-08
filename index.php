<?php

header('Content-Type: text/html; charset=UTF-8');

require_once __DIR__ . '/autoload.php';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function creerCatalogue(): Catalogue
{
    $catalogue = new Catalogue();

    $inception = new Film(
        'film-001',
        'Inception',
        'Un voleur specialise dans les reves doit realiser une mission presque impossible.',
        148,
        2010,
        'Christopher Nolan',
        'Science-fiction',
        4.8,
        'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?auto=format&fit=crop&w=900&q=80',
        160000000,
        839000000,
        'Anglais'
    );

    $whiplash = new Film(
        'film-002',
        'Whiplash',
        'Un jeune batteur ambitieux affronte un professeur aussi brillant que brutal.',
        107,
        2014,
        'Damien Chazelle',
        'Drame',
        4.7,
        'https://images.unsplash.com/photo-1511192336575-5a79af67a629?auto=format&fit=crop&w=900&q=80',
        3300000,
        49000000,
        'Anglais'
    );

    $arcane = new Serie(
        'serie-001',
        'Arcane',
        'Deux soeurs se retrouvent opposees dans une ville dechiree par la magie et le pouvoir.',
        42,
        2021,
        'Christian Linke',
        'Animation',
        4.9,
        'https://images.unsplash.com/photo-1614728263952-84ea256f9679?auto=format&fit=crop&w=900&q=80',
        2
    );
    $arcane->ajouterEpisode(new Episode(1, 'Bienvenue au terrain de jeu', 'La tension monte entre les quartiers de Piltover et Zaun.', 43, new DateTime('2021-11-06')));
    $arcane->ajouterEpisode(new Episode(2, 'Certains mysteres', 'Jayce tente de comprendre une technologie qui pourrait tout changer.', 41, new DateTime('2021-11-06')));

    $planete = new Serie(
        'serie-002',
        'Planete Bleue',
        'Une serie documentaire qui explore les oceans et leurs ecosystemes.',
        50,
        2017,
        'David Attenborough',
        'Documentaire',
        4.6,
        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80',
        1
    );
    $planete->ajouterEpisode(new Episode(1, 'Grand bleu', 'Une plongee dans la vie marine et ses strategies de survie.', 50, new DateTime('2017-10-29')));

    foreach ([$inception, $whiplash, $arcane, $planete] as $video) {
        $catalogue->ajouterVideo($video);
    }

    return $catalogue;
}

$catalogue = creerCatalogue();
$recherche = trim($_GET['q'] ?? '');
$genre = trim($_GET['genre'] ?? '');
$videos = $recherche !== '' ? $catalogue->rechercher($recherche) : $catalogue->filtrerParGenre($genre);

$playlist = new Playlist('A regarder ce soir');
foreach (array_slice($catalogue->getVideos(), 0, 3) as $video) {
    $playlist->ajouterVideo($video);
}

$utilisateur = new Utilisateur('Eulalia', 'eulalia@example.com');
$utilisateur->ajouterPlaylist($playlist);
$totalVideos = count($catalogue->getVideos());
$dureePlaylist = $playlist->getDureeTotale();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamPOO</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #101114;
            --panel: #181b20;
            --panel-2: #20242b;
            --text: #f6f4ee;
            --muted: #b8b3aa;
            --accent: #f2554a;
            --accent-2: #36c5b0;
            --line: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            color: inherit;
        }

        .shell {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 2;
            border-bottom: 1px solid var(--line);
            background: rgba(16, 17, 20, 0.9);
            backdrop-filter: blur(14px);
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 72px;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .brand-mark {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 8px;
            background: var(--accent);
            color: white;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 32px;
            align-items: end;
            padding: 42px 0 28px;
        }

        h1 {
            max-width: 760px;
            margin: 0 0 16px;
            font-size: clamp(2rem, 4vw, 4rem);
            line-height: 1;
        }

        .lead {
            max-width: 690px;
            margin: 0;
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.65;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .stat {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            padding: 16px;
        }

        .stat strong {
            display: block;
            font-size: 1.6rem;
        }

        .stat span {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .filters {
            display: grid;
            grid-template-columns: minmax(180px, 1fr) 210px 120px;
            gap: 12px;
            margin: 20px 0 28px;
        }

        input,
        select,
        button {
            width: 100%;
            min-height: 46px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 0 14px;
            font: inherit;
        }

        input,
        select {
            background: var(--panel);
            color: var(--text);
        }

        button {
            cursor: pointer;
            border-color: transparent;
            background: var(--accent);
            color: white;
            font-weight: 700;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 18px;
            padding-bottom: 44px;
        }

        .card {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
        }

        .poster {
            position: relative;
            min-height: 220px;
            background: var(--panel-2);
        }

        .poster img {
            width: 100%;
            height: 220px;
            display: block;
            object-fit: cover;
        }

        .badge {
            position: absolute;
            top: 12px;
            left: 12px;
            border-radius: 999px;
            background: rgba(16, 17, 20, 0.82);
            padding: 7px 10px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .rating {
            position: absolute;
            right: 12px;
            bottom: 12px;
            border-radius: 8px;
            background: var(--accent-2);
            color: #061513;
            padding: 8px 10px;
            font-weight: 800;
        }

        .content {
            padding: 18px;
        }

        .content h2 {
            margin: 0 0 8px;
            font-size: 1.35rem;
        }

        .description {
            min-height: 72px;
            margin: 0 0 14px;
            color: var(--muted);
            line-height: 1.5;
        }

        .details {
            display: grid;
            gap: 6px;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .details p {
            margin: 0;
        }

        .episodes {
            display: grid;
            gap: 10px;
            margin: 10px 0 0;
            padding: 0;
            list-style: none;
        }

        .episodes li {
            border-left: 3px solid var(--accent);
            padding-left: 10px;
        }

        .episodes span {
            display: block;
            color: var(--muted);
            font-size: 0.85rem;
            margin: 3px 0;
        }

        .empty {
            border: 1px dashed var(--line);
            border-radius: 8px;
            padding: 28px;
            color: var(--muted);
            text-align: center;
        }

        footer {
            border-top: 1px solid var(--line);
            color: var(--muted);
            padding: 22px 0 34px;
        }

        @media (max-width: 820px) {
            .hero,
            .filters {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="shell topbar">
            <div class="brand">
                <span class="brand-mark">S</span>
                <span>StreamPOO</span>
            </div>
            <span><?= e($utilisateur->getNom()) ?> - <?= e($utilisateur->getEmail()) ?></span>
        </div>
    </header>

    <main class="shell">
        <section class="hero">
            <div>
                <h1>Catalogue streaming en PHP oriente objet</h1>
                <p class="lead">Films, series, episodes, playlist utilisateur, recherche et filtres: le projet montre les bases POO avec heritage, abstraction, encapsulation et composition.</p>
            </div>
            <div class="stats" aria-label="Statistiques">
                <div class="stat">
                    <strong><?= $totalVideos ?></strong>
                    <span>videos</span>
                </div>
                <div class="stat">
                    <strong><?= count(Video::GENRES) ?></strong>
                    <span>genres</span>
                </div>
                <div class="stat">
                    <strong><?= $dureePlaylist ?>min</strong>
                    <span>playlist</span>
                </div>
            </div>
        </section>

        <form class="filters" method="get">
            <input type="search" name="q" placeholder="Rechercher un titre, genre ou mot-cle" value="<?= e($recherche) ?>">
            <select name="genre">
                <option value="">Tous les genres</option>
                <?php foreach (Video::GENRES as $genreOption): ?>
                    <option value="<?= e($genreOption) ?>" <?= $genre === $genreOption ? 'selected' : '' ?>>
                        <?= e($genreOption) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrer</button>
        </form>

        <?php if (count($videos) === 0): ?>
            <p class="empty">Aucun contenu ne correspond a cette recherche.</p>
        <?php else: ?>
            <section class="grid" aria-label="Catalogue">
                <?php foreach ($videos as $video): ?>
                    <article class="card">
                        <div class="poster">
                            <img src="<?= e($video->getUrlAffiche()) ?>" alt="Affiche de <?= e($video->getTitre()) ?>">
                            <span class="badge"><?= e($video->getType()) ?> - <?= e($video->getGenre()) ?></span>
                            <span class="rating"><?= number_format($video->getNotation(), 1) ?>/5</span>
                        </div>
                        <div class="content">
                            <h2><?= e($video->getTitre()) ?></h2>
                            <p class="description"><?= e($video->getDescription()) ?></p>
                            <div class="details">
                                <?= $video->afficherDetails() ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <div class="shell">
            Playlist "<?= e($playlist->getNom()) ?>" avec <?= count($playlist->getVideos()) ?> contenus selectionnes.
        </div>
    </footer>
</body>
</html>
