<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("refresh: 4;");

foreach($rolls as $roll)
{
    if($roll->doubleroll){
        echo('<span class="roll__bold">'.$roll->who.' </span>rolled twice: '.'<span class="roll__bold">'.$roll->value.'</span><br>');
        echo($roll->what.'<br><br>');
    }else{
        echo('<span class="roll__bold">'.$roll->who.' </span>rolled '.'<span class="roll__bold">'.$roll->value.'</span><br>');
        echo($roll->what.'<br><br>');
    }
}

 ?>
