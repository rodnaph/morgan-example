<?php

require __DIR__ . '/../vendor/autoload.php';

use Morgan\Template as T;
use Silex\Application;

// This template is the main layout for the site.  It handles setting some
// titles, and also filling in the main content parts of the page.

$layout = T::template(
    '../views/layout.html',
    function($data) {
        return array(
            'title' => T::append(' - ' . $data['title']),
            'h1' => T::content($data['title'])
        );
    }
);

// This snippet allows us to render a summary view for some things.  We can
// use this whever we need to render things in a list.

$thingSummary = T::snippet(
    '../views/list.html',
    '.thing',
    function($data) {
        return array(
            'h3' => T::content($data['title']),
            'p' => T::content($data['summary'])
        );
    }
);

// This page lists some content, it uses the main layout for the
// chrome of the page, then replaces the main section with a snippet
// extracted from another HTML file.

$listPage = T::template(
    '../views/layout.html',
    function($things, $data) use ($thingSummary) {
        return array(
            'h1' => T::content($data['title']),
            '.content' => T::mapSnippet($thingSummary, $things)
        );
    }
);

// Now we can define a simple Silex application with a few routes

$app = new Application();

$app->get('/list', function() use ($listPage, $things) {

    // This is a list of some data, for simplicity sake it's just hard-coded
    // arrays, but it could equally be models we've just extracted from the
    // database and need to render.

    $things = array(
        array(
            'title' => 'First Thing',
            'summary' => 'This is a description of the first thing.'
        ),
        array(
            'title' => 'Another One',
            'summary' => 'The text that appears here concerns the second thing.'
        )
    );

    return $listPage(
        $things,
        array(
            'title' => 'List of Stuff'
        )
    );

});

$app->get('/', function() use ($layout) {

    return $layout(
        array(
            'title' => 'Home Page'
        )
    );

});

$app->run();

