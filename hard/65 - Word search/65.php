<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/65/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $cols = 4;
                $rows = 3;
                $grid = array('A','B','C','E','S','F','C','S','A','D','E','E');
                $neighbours = array();
                $grid_max = $cols * $rows;
                for( $i = 0 ; $i < $grid_max ; $i++ ){
                    if( !isset($neighbours[$i]) ){
                        $neighbours[$i] = array();
                    }
                    
                    $col = $i % $cols;
                    $row = floor($i / $cols);
                    
                    // left
                    if( $col > 0 ){
                        $neighbours[$i][] = $i-1;
                    }
                    // right
                    if( $col < $cols-1 ){
                        $neighbours[$i][] = $i+1;
                    }
                    // top
                    if( $row > 0 ){
                        $neighbours[$i][] = $i - $cols;
                    }
                    // bottom
                    if( $row < $rows-1 ){
                        $neighbours[$i][] = $i + $cols;
                    }
                }
                
                function browse_grid($letters, $depth = 0 , $grid_idx = false, $used = array() ){
                    global $neighbours, $grid, $grid_max;
                    
                    $found = false;
                    if( $depth < count($letters) ){
                        $letter = $letters[$depth];
                        
                        if( $grid_idx === false ){
                            // I try to find one or more starting points
                            for( $i = 0 ; $i < $grid_max ; $i++ ){
                                if( $grid[$i] === $letter ){
                                    // echo 'found '.$letter.' '.$i."\n";
                                    $found = $found || browse_grid($letters, $depth+1, $i, array( $i => true));
                                }
                            }
                        }
                        else{
                            $neighbours_idx = $neighbours[$grid_idx];
                            $neighbours_cnt = count($neighbours_idx);
                            for( $i = 0 ; $i < $neighbours_cnt ; $i++){
                                $neighbour = $neighbours_idx[$i];
                                if( ($grid[$neighbour] === $letter) && !isset($used[$neighbour]) ){
                                    $next_used = $used;
                                    $next_used[$neighbour] = true;
                                    $found = $found || browse_grid($letters, $depth+1, $neighbour, $next_used);
                                }
                            }
                        }
                    }
                    else{
                        $found = true;
                    }
                    return $found;
                }
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $letters = str_split($line, 1);
                        $len = count($letters);
                        echo ( browse_grid($letters) ? 'True' : 'False' ) . "\n";
                    }
                    
                }//
                fclose( $fp );
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
