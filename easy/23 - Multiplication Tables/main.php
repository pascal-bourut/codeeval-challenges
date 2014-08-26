<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/23/

$max = 12;

/*
Print out the table in a matrix like fashion, each number formatted to a width of 4 
(The numbers are right-aligned and strip out leading/trailing spaces on each line). The first 3 line will look like:
*/

for($i=1 ; $i <= $max ; ++$i){
    for($j=1 ; $j <= $max ; ++$j){
        $nb = $i * $j; 
        if( $j > 1){
            echo str_repeat(' ',4-strlen($nb));
        }
        echo $nb;
    }
    echo "\r\n";
}

exit(0);
?>