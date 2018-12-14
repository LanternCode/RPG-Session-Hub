<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("refresh: 4;");

foreach($rolls as $roll)
{
    if( $roll->doubleroll )
    {
        echo('<span class="roll__bold">' . htmlspecialchars($roll->who) . ' </span> ' .
            ( isset($roll->dice) && $roll->dice ? ( '(' . $roll->dice . ')' ) : '' )
                . ' rolled twice: '.'<span class="roll__bold">' . htmlspecialchars($roll->value) . '</span><br >');

        echo( htmlspecialchars($roll->what) . '<br /><br />');
    }
    else
    {
        echo('<span class="roll__bold">' . htmlspecialchars($roll->who) . ' </span> ' .
            ( isset($roll->dice) && $roll->dice ? ( '(' . $roll->dice . ')' ) : '' )
                . ' rolled '.'<span class="roll__bold">' . htmlspecialchars($roll->value) . '</span><br />');

        echo( htmlspecialchars($roll->what) . '<br /><br />');
    }
}

 ?>
