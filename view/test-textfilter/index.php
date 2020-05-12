<?php

namespace Anax\View;

$markdownTest = <<<EOD
En H1-rubrik
============

## En H2-rubrik

En paragraf

En lista:

* Första grejen
* Andra grejen
* Tredje grejen

[En länk till Google](http://www.google.com)
EOD;

$bbcodeTest = <<<EOD
[b]Bold text[/b] [i]Italic text[/i] [url=http://dbwebb.se]a link to dbwebb[/url]

Här är en länk direkt i texten: http://www.google.com

And then an image.
[img]https://dbwebb.se/image/tema/trad/blad.jpg[/img]
EOD;

?>

<h1>Test av textfiltret</h1>

<h3> BBcode, makeClickable och nl2br utan filter:</h3>
<pre>
<?= $bbcodeTest ?>
</pre>
<h3> BBcode, makeClickable och nl2br med filter:</h3>
<?= $textfilter->parse($bbcodeTest, ["bbcode", "nl2br", "link"]) ?>
<hr>
<h3> Markdown utan filter:</h3>
<pre>
<?= $markdownTest ?>
</pre>
<h3> Markdown med filter:</h3>
<?= $textfilter->parse($markdownTest, ["markdown"]) ?>
<hr>

