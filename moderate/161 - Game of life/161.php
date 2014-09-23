<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/161/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function game_of_life($grid, $size){
    $max = $size * $size;
    // count live neighbors of every cell
    $neighbors = array_fill(0,$max,0);
    for( $i=0; $i < $max ; $i++ ){
        $c = $i % $size;
        $r = ($i / $size) >> 0;
        // echo $i.': '.$c.'x'.$r."\n";
        if( $grid[$i] == '*' ){
            // alive
            
            if( $c > 0 ){
                $neighbors[$i - 1]++; // update left neighbor
                if( $r > 0 ){
                    $neighbors[$i - $size - 1]++; // update top-left neighbor
                }
                if( $r < $size-1 ){
                    $neighbors[$i + $size - 1]++; // update bottom-left neighbor
                }
            }
            if( $c < $size-1 ) {
                $neighbors[$i + 1]++; // update right neighbor
                if( $r > 0 ){
                    $neighbors[$i - $size + 1]++; // update top-right neighbor
                }
                if( $r < $size-1 ){
                    $neighbors[$i + $size + 1]++; // update bottom-right neighbor
                }
            }
            if( $r > 0 ){
                $neighbors[$i - $size]++; // update top neighbor
            }
            if( $r < $size-1 ){
                $neighbors[$i + $size]++; // update bottom neighbor
            }
        }
    }
    
    for( $i=0 ; $i < $max ; $i++ ){
        $alive = ($grid[$i] == '*');
        $cnt = $neighbors[$i];
        if( $alive ){
            // alive
            if( $cnt < 2 || $cnt > 3 ){
                // Any live cell with fewer than two live neighbors dies, as if caused by under-population.
                // Any live cell with more than three live neighbors dies, as if by overcrowding.
                $grid[$i] = '.';
            }
        }
        else{
            // dead
            // Any dead cell with exactly three live neighbors becomes a live cell, as if by reproduction.
            if( $cnt == 3 ){
                $grid[$i] = '*';
            }
        }
    }
    
    return $grid;
}

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $grid = '';
                $size = 0;
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        if(!$size) {
                            $size = strlen($line);
                        }
                        $grid .= $line;
                    }
                }//
                fclose( $fp );
                
                $i = 10;
                while( $i-- ){
                    $grid = game_of_life($grid, $size);
                }
                echo implode("\n",str_split($grid,$size))."\n";
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
