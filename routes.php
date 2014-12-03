<?php

if ($user->requiresLogin()) {
    $router->get('', function() use ($htmlTemplate, $csrfToken) {
        return $htmlTemplate->render('login.phtml', [
            'csrfToken' => $csrfToken,
            'username'  => null,
            'login'     => true,
            'title'     => 'Login',
        ]);
    });

    $router->post('', function() use ($htmlTemplate, $csrfToken, $request, $user, $request) {
        if ($csrfToken->validate($request->post('csrfToken')) && $user->login($request->post('username'), $request->post('password'), $request->getIp())) {
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
