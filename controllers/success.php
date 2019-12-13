<?php

if(!empty($_GET['tid'] && !empty($_GET['product']))) {
    $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);
    $tid = $GET['tid'];
    $product = $GET['product'];
}
