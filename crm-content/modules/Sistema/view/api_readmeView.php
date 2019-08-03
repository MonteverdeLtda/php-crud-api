<?php

/*
require_once 'crm-admin/core/markdown/markdown.php';

$my_html = Markdown($my_text);
*/
require_once 'crm-admin/core/parsedown/Parsedown.php';
$my_text = @file_get_contents(folder_principal . "/README.md");

$Parsedown = new Parsedown();
$my_html = $Parsedown->text($my_text);
echo $my_html;