<?php

require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;



$dompdf = new Dompdf;

$dompdf -> loadHtml("Hello world");
$dompdf->render();
$dompdf->stream();