<?php

function dump(...$args)
{
    echo '<pre style="font-size:2vmin">';
    foreach (func_get_args() as $arg) {
        var_dump($arg);
    }
    echo '</pre>';
}