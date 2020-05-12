<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Showing message Hello World, not using the standard page layout.
 */
$app->router->get("test-textfilter", function () use ($app) {
    $title = "Test of my textfilter";
    $data = [
        "textfilter" => new Karl\TextFilter\MyTextFilter(),
    ];

    $app->page->add("test-textfilter/index", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
