<?php

use OpCacheGUI\Network\Router;

$router->get('mainjs', function() {
    header('Content-Type: application/javascript');
    readfile(__DIR__ . '/public/js/main.js');
    exit;
});

$router->get('maincss', function() use ($uriScheme) {
    header('Content-Type: text/css');

    $prefix = '?';
    if ($uriScheme === Router::URL_REWRITE) {
        $prefix = '/';
    }

    echo str_replace('{urltype}', $prefix, file_get_contents(__DIR__ . '/public/style/main.css'));
    exit;
});

$router->get('fontawesome-webfont_eot', function() {
    header('Content-Type: application/vnd.ms-fontobject');
    readfile(__DIR__ . '/public/style/fonts/fontawesome-webfont.eot');
    exit;
});

$router->get('fontawesome-webfont_woff', function() {
    header('Content-Type: font/x-woff');
    readfile(__DIR__ . '/public/style/fonts/fontawesome-webfont.woff');
    exit;
});

$router->get('fontawesome-webfont_ttf', function() {
    header('Content-Type: font/ttf');
    readfile(__DIR__ . '/public/style/fonts/fontawesome-webfont.ttf');
    exit;
});

$router->get('fontawesome-webfont_svg', function() {
    header('Content-Type: image/svg+xml');
    readfile(__DIR__ . '/public/style/fonts/fontawesome-webfont.svg');
    exit;
});

if ($user->requiresLogin()) {
    $router->get('', function() use ($htmlTemplate, $csrfToken, $translator) {
        return $htmlTemplate->render('login.phtml', [
            'csrfToken' => $csrfToken,
            'username'  => null,
            'login'     => true,
            'title'     => 'Login',
        ]);
    });

    $router->post('', function() use ($htmlTemplate, $csrfToken, $request, $user, $request) {
        if ($csrfToken->validate($request->post('csrfToken')) && $user->login($request->post('username'), $request->post('password'))) {
            header('Location: ' . $request->getUrl());
            exit;
        }

        return $htmlTemplate->render('login.phtml', [
            'csrfToken' => $csrfToken,
            'username'  => $request->post('username'),
            'login'     => true,
        ]);
    });

    return;
}

$router->get('', function() use ($htmlTemplate, $byteFormatter, $csrfToken, $translator) {
    return $htmlTemplate->render('status.phtml', [
        'byteFormatter' => $byteFormatter,
        'csrfToken'     => $csrfToken,
        'active'        => 'status',
        'title'         => $translator->translate('stats.title'),
    ]);
});

$router->get('configuration', function() use ($htmlTemplate, $byteFormatter, $translator) {
    return $htmlTemplate->render('configuration.phtml', [
        'byteFormatter' => $byteFormatter,
        'active'        => 'config',
        'title'         => $translator->translate('config.title'),
    ]);
});

$router->get('cached-scripts', function() use ($htmlTemplate, $byteFormatter, $csrfToken, $translator) {
    return $htmlTemplate->render('cached.phtml', [
        'byteFormatter' => $byteFormatter,
        'csrfToken'     => $csrfToken,
        'active'        => 'cached',
        'title'         => $translator->translate('scripts.title'),
    ]);
});

$router->get('graphs', function() use ($htmlTemplate, $byteFormatter, $translator) {
    return $htmlTemplate->render('graphs.phtml', [
        'byteFormatter' => $byteFormatter,
        'active'        => 'graphs',
        'title'         => $translator->translate('graph.title'),
    ]);
});

$router->post('reset', function() use ($jsonTemplate, $csrfToken, $request) {
    return $jsonTemplate->render('reset.pjson', [
        'csrfToken' => $csrfToken,
        'result'    => ($csrfToken->validate($request->post('csrfToken')) && opcache_reset()) ? 'success' : 'failed',
    ]);
});

$router->post('invalidate', function() use ($jsonTemplate, $csrfToken, $request) {
    return $jsonTemplate->render('invalidate.pjson', [
        'csrfToken' => $csrfToken,
        'result'    => ($csrfToken->validate($request->post('csrfToken')) && opcache_invalidate($request->post('key'), true)) ? 'success' : 'failed',
    ]);
});

$router->get('apcuimg1', function() {
    OpCacheGUI\Addons\APCUHelper::createimg(1);
});

$router->get('apcuimg2', function() {
    OpCacheGUI\Addons\APCUHelper::createimg(2);
});


$router->get('apcuimg3', function() {
    OpCacheGUI\Addons\APCUHelper::createimg(3);
});

$router->get('apcustatus', function() use ($htmlTemplate, $byteFormatter, $csrfToken, $translator) {
    return $htmlTemplate->render('apcustatus.phtml', [
        'byteFormatter' => $byteFormatter,
        'csrfToken'     => $csrfToken,
        'active'        => 'apcustatus',
        'title'         => $translator->translate('apcu.status'),
    ]);
});

$router->get('apcuconfig', function() use ($htmlTemplate, $translator) {
    return $htmlTemplate->render('apcuconfig.phtml', [
        'active'        => 'apcuconfig',
        'title'         => $translator->translate('apcu.config.title'),
    ]);
});

$router->get('apcuvars', function() use ($htmlTemplate, $byteFormatter,$csrfToken,$translator) {
    return $htmlTemplate->render('apcuvars.phtml', [
        'byteFormatter' => $byteFormatter,
        'csrfToken'     => $csrfToken,
        'active'        => 'apcuvars',
        'title'         => $translator->translate('apcu.cached_vars'),
    ]);
});

$router->post('resetapcu', function() use ($jsonTemplate, $csrfToken, $request) {
    return $jsonTemplate->render('resetapcu.pjson', [
        'result'    => ($csrfToken->validate($request->post('csrfToken')) && apcu_clear_cache()) ? 'success' : 'failed',
    ]);
});
