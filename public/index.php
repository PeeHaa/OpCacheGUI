<?php

require __DIR__ . '/../bootstrap.php';

$status = opcache_get_status();

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
