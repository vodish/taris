<?php
load::$layout   =   'default.tpl.php';
load::$title    =   'Site YYYY';
?>


<h1>Php Hot Rod</h1>

<div>SiteYYYY main page</div>

<?
echo array(
    url::$path  => '<p><a href="/next">Next Page</a></p>',
    '/next'     => '<p><a href="/">Back</a></p>',
)[ url::$path ]
?>

