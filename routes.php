<?php

$router->get('', function() use ($htmlTemplate, $byteFormatter, $csrfToken) {
    return $htmlTemplate->render('status.phtml', [
        'byteFormatter' => $byteFormatter,
        'csrfToken'     => $csrfToken,
        'active'        => 'status',
    ]);
});

$router->get('configuration', function() use ($htmlTemplate, $byteFormatter) {
    return $htmlTemplate->render('configuration.phtml', [
        'byteFormatter' => $byteFormatter,
        'active'        => 'config',
    ]);
});

$router->get('cached-scripts', function() use ($htmlTemplate, $byteFormatter, $csrfToken) {
    return $htmlTemplate->render('cached.phtml', [
        'byteFormatter' => $byteFormatter,
        'csrfToken'     => $csrfToken,
        'active'        => 'cached',
    ]);
});

$router->get('graphs', function() use ($htmlTemplate, $byteFormatter) {
    return $htmlTemplate->render('graphs.phtml', [
        'byteFormatter' => $byteFormatter,
        'active'        => 'graphs',
    ]);
});

$router->post('reset', function() use ($jsonTemplate, $csrfToken) {
    return $jsonTemplate->render('reset.pjson', [
        'csrfToken' => $csrfToken,
    ]);
});

$router->post('invalidate', function() use ($jsonTemplate, $csrfToken) {
    return $jsonTemplate->render('invalidate.pjson', [
        'csrfToken' => $csrfToken,
    ]);
});
