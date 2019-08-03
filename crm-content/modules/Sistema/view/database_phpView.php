<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

//session_start();
$ui = new PHP_CRUD_UI(array(
    'url' => '/index.php',
));
$html = $ui->executeCommand();

echo $html;
echo json_encode($ui);