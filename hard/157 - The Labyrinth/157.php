<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/157/

function bfs( $graph, $start, $end ){
    $distance = array();
    foreach ( $graph as $k => $v ){
        $distance[ $k ] = -1;
    }
    $distance[ $start ] = 0;
    
    $previous = array($start => null);
    $q = array( $start );
    
    while ( !empty( $q ) ){
        $v = array_shift( $q );
        foreach ( $graph[ $v ] as $u ){
            if ( $u == $end ) {
                $previous[$end] = $v;
                return $previous;
            }
            if ( !isset($previous[$u]) ){
                $distance[ $u ] = $distance[ $v ] + 1;
                $q[] = $u;
                $previous[$u] = $v;
            }
        }
    }
    return false;
}//


if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];
if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $cols = 0;
                $rows = 0;
                $labyrinth = '';

                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        if( !$cols ){
                            $cols = strlen($line);
                        }
                        $labyrinth .= $line;
                        $rows++;
                    }
                    
                }//
                fclose( $fp );
                
                $entrance = strpos($labyrinth, ' ');
                $exit = strrpos($labyrinth, ' ');
                /*
                echo $labyrinth."\n";
                echo $cols.'x'.$rows."\n";
                echo 'from ' . $entrance.' to '.$exit."\n";
                */
                $graph = array();
                $len = strlen($labyrinth);
                $i = $len;
                while($i--){
                    $l = $labyrinth[$i];
                    if( $l === ' ' ){
                        $x = $i%$cols;
                        $y = floor($i/$cols);
                        $test = array();
                        // left
                        if( $x > 0 ){
                            $test[] = $i - 1;
                        }
                        // right
                        if( $x < ($cols-1) ){
                            $test[] = $i + 1;
                        }
                        // top
                        if( $y > 0 ){
                            $test[] = $i - $cols;
                        }
                        // bottom
                        if( $y < ($rows-1) ){
                            $test[] = $i + $cols;
                        }
                        
                        for($j=0, $cnt=count($test); $j < $cnt ; $j++){
                            $t = $test[$j];
                            if( $labyrinth[$t] === ' ' ){
                                $graph[$i][] = $t;
                            }
                        }
                    }
                }
                
                // print_r($graph);
                
                $result = bfs($graph, $entrance, $exit); 
                if( $result ){
                    $end = $exit;
                    $labyrinth[$end] = '+';
                    do{
                        $end = $result[$end];
                        $labyrinth[$end] = '+';
                    }
                    while( $end != $entrance );
                }
                
                // display labyrinth
                for( $i=0 ; $i < $rows  ; $i++ ){
                    echo substr($labyrinth, $i * $cols , $cols)."\n";
                }
            }
            else{
                echo '!fp'."\n";
            }
        }
        else{
            echo '!readable'."\n";
        }
    }
    else{
        echo '!file_exists'."\n";
    }
}
else{
    echo '!argv[1]'."\n";
}

exit(0);

?>
