<?php
require('vendor/autoload.php');

use ExtractData\Extract;

$extract = new Extract();
$baseUrl = 'http://www.guiatrabalhista.com.br/';
$uri = '/guia/salario_minimo.htm';
$data = $extract->extract($baseUrl, $uri);

echo '<pre>';
echo var_dump($data);
echo '</pre>';