<?php
declare(strict_types=1);
require ROOT_PATH . '/partials/header.php';
?>
<header class="site-header is-scrolled">
    <div class="container header-inner">
        <a class="brand" href="index.php"><img src="assets/images/logo-96.webp" width="44" height="44" alt=""><span>CRM <i>for services</i></span></a>
        <a class="button button--small" href="<?= e($content['links']['developer']) ?>" target="_blank" rel="noopener noreferrer">Связаться</a>
    </div>
</header>
<main class="legal-page" id="main">
    <article class="container legal-wrap">
        <a class="legal-back" href="index.php">← На главную</a>
        <p class="eyebrow"><span></span>Документы</p>
        <h1><?= e($legalTitle) ?></h1>
        <p>Дата последнего обновления: <?= e($legalUpdated ?? '21 августа 2026 года') ?></p>
        <?php foreach ($legalSections as $section): ?>
            <section>
                <h2><?= e($section['title']) ?></h2>
                <?php foreach ($section['paragraphs'] ?? [] as $paragraph): ?><p><?= $paragraph ?></p><?php endforeach; ?>
                <?php if (!empty($section['items'])): ?><ul><?php foreach ($section['items'] as $item): ?><li><?= $item ?></li><?php endforeach; ?></ul><?php endif; ?>
            </section>
        <?php endforeach; ?>
    </article>
</main>
<?php require ROOT_PATH . '/partials/footer.php'; ?>

