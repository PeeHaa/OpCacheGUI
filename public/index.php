<?php

require __DIR__ . '/../bootstrap.php';

$status      = new OpCacheGUI\OpCache\Status($byteFormatter);
$classCycler = new OpCacheGUI\Presentation\ClassCycler(['odd', 'even']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>OpCacheGUI 1.0</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/style/style.css">
        <link rel="shortcut icon" href="/favicon.ico">
        <script>'article aside footer header nav section time'.replace(/\w+/g,function(n){document.createElement(n)})</script>
    </head>
    <body>
        <header>
            <div class="content">
                <h1><a href="/">PHP <?= phpversion(); ?> OpCache x</a></h1>
                <nav>
                    <ul>
                        <li class="active"><a href="/">Status</a></li>
                        <li><a href="/">Configuration</a></li>
                        <li><a href="/">Cached scripts</a></li>
                        <li><a href="/">Graphs</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div id="body">
            <article class="cols-3 first">
                <h2><?= $translator->translate('status.title'); ?></h2>
                <table>
                    <?php foreach ($status->getStatusInfo() as $key => $statusItem) { ?>
                        <tr class="<?= $classCycler->next(); ?>">
                            <th><?= $translator->translate('status.' . $key); ?></th>
                            <td><img src="/style/bullet-<?= $statusItem ? 'green' : 'red'; ?>-icon.png"></td>
                        </tr>
                    <?php } ?>
                </table>
            </article>
            <article class="cols-3">
                <h2><?= $translator->translate('memory.title'); ?></h2>
                <table>
                    <?php $classCycler->rewind(); ?>
                    <?php foreach ($status->getMemoryInfo() as $key => $memoryItem) { ?>
                        <tr class="<?= $classCycler->next(); ?>">
                            <th><?= $translator->translate('memory.' . $key); ?></th>
                            <td><?= $memoryItem; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </article>
            <article class="cols-3">
                <h2><?= $translator->translate('stats.title'); ?></h2>
                <table>
                    <?php $classCycler->rewind(); ?>
                    <?php foreach ($status->getStatsInfo() as $key => $statisticItem) { ?>
                        <tr class="<?= $classCycler->next(); ?>">
                            <th><?= $translator->translate('stats.' . $key); ?></th>
                            <td><?= $statisticItem; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </article>
        </div>
        <footer>
            <ul>
                <li>OpCacheGUI <?= (new DateTime())->format('Y'); ?></li>
                <li class="divider">-</li>
                <li><a href="https://github.com/PeeHaa/OpCacheGUI" target="_blank">Projectpage on GitHub</a></li>
                <li class="divider">-</li>
                <li>Maintained by <a href="https://github.com/PeeHaa" target="_blank">Pieter Hordijk</a></li>
            </ul>
        </footer>
</body>
</html>
