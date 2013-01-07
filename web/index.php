<?php

require __DIR__ . '/../vendor/autoload.php';

use Morgan\Template as T;
use Silex\Application;

// This template is the main layout for the site.  It handles setting some
// titles, and also filling in the main content parts of the page.

$layout = T::template(
    '../views/layout.html',
    function($title, $html = null) {
        return array(
            'title' => T::append(' - ' . $title),
            'h1' => T::content($title),
            '.content' => T::htmlContent($html)
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

$listPage = T::snippet(
    '../views/list.html',
    '.content',
    function($things) use ($thingSummary) {
        return array(
            '.things' => T::map($thingSummary, $things)
        );
    }
);

// Now we can define a simple Silex application with a few routes

$app = new Application();

$app->get('/list', function() use ($layout, $listPage) {

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

    return $layout('List of Stuff', $listPage($things));

});

$app->get('/', function() use ($layout) {

    return $layout('Home Page');

});

$app->run();

