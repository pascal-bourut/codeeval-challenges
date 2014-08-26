<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/72/

function make_neighbours($n, $grid){
    $grid_max = $n * $n;
    $i = $grid_max;
    while( $i-- ){
        
        // right
        if( $i%$n < $n-1 ){
            $neighbours[$i]['r'] = $i + 1;
        }
        // bottom
        if( $i < $grid_max-$n ){
            $neighbours[$i]['b'] = $i + $n;
        }
    }
    return $neighbours;
};

function scan_grid ($grid, $target, $neighbours, $idx=0, $sum=0, $min = INF){
    
    $sum += $grid[ $idx ];
    
    if( $sum >= $min ) {
        return $min;
    }
    
    if( $idx == $target ){
        return $sum;
    }
    else{
        if( isset($neighbours[$idx]['r']) ){
            $m = scan_grid($grid, $target, $neighbours, $neighbours[$idx]['r'], $sum, $min);
            if( $m < $min ) $min = $m;
        }
        if( isset($neighbours[$idx]['b']) ){
            $m = scan_grid($grid, $target, $neighbours, $neighbours[$idx]['b'], $sum, $min);
            if( $m < $min ) $min = $m;
        }
    }
    return $min;
};

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $lines = array();
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets( $fp ));
                    $lines[] = $line;
                }//
                fclose( $fp );
                
                $nb = count($lines);
                for($i=0 ; $i < $nb ; ){
                    $n = (int)$lines[$i];
                    $rows = '';
                    for( $j=1 ; $j <= $n ; $j++){
                        $row = $lines[$i+$j];
                        if($j>1) $rows .= ',';
                        $rows .= $row;
                    }
                    $cells = explode(',', $rows);
                    
                    $neighbours = make_neighbours($n,$cells);
                    
                    echo scan_grid($cells, $n * $n - 1, $neighbours)."\n";
                    
                    $i += ($n+1);
                }

            }
            else{
                echo '!fp'."\r\n";
            }
        }
        else{
            echo '!readable'."\r\n";
        }
    }
    else{
        echo '!file_exists'."\r\n";
    }
}
else{
    echo '!argv[1]'."\r\n";
}

exit(0);
