<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// our autoloader
require __DIR__ . '/../inc/autoload.php';

// Composer autoloader
require __DIR__ . '/../lib/vendor/autoload.php';

ToroHook::add('404',  function () {
    http_response_code(404);
    exit ('404 Not Found');
});

try {
    // Router
    Toro::serve([
        '/' => 'handlers\ListOfWords',
        '/api/classes' => 'handlers\api\ListOfClasses',
        '/api/genders' => 'handlers\api\ListOfGenders',
        '/api/letters' => 'handlers\api\ListOfLetters',
        '/api/ping' => 'handlers\api\Ping',
        '/api/types' => 'handlers\api\ListOfTypes',
        '/api/words' => 'handlers\api\ListOfWords',
        '/api/words/(\d+)' => 'handlers\api\Word',
        '/dump/' => 'handlers\Dump',
        '/log/' => 'handlers\Log',
        '/login/' => 'handlers\Login',
        '/logout/' => 'handlers\Logout',
        '/new/' => 'handlers\NewWord',
        '/search/' => 'handlers\Search',
        '/words/(\d+)/' => 'handlers\Word',
        '/words/(\d+)/edit/' => 'handlers\EditWord',
        '/xetex' => 'handlers\XeTeX',
    ]);

} catch (Exception $e) {
    if ($e->getMessage() === 'Access Denied') {
        http_response_code(401);
        exit ('401 Unauthorized');
    }

    throw $e;
}
