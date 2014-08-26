<?php
header('Content-Type: text/plain; charset=utf-8');

https://www.codeeval.com/open_challenges/79/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        if( preg_match('/^([0-9]+),([0-9]+);([\.\*]+)$/',$line,$tokens) ){
                            // print_r($tokens);
                            $n = $tokens[1];
                            $m = $tokens[2];
                            $mines = str_split($tokens[3],1);
                            
                            $grid = array();
                            $max = $m * $n;
                            for($i = 0 ; $i < $max ; $i++){
                                $X = $i % $m;
                                $Y = floor($i / $m);
                                // echo $i.': '.$X,',',$Y."\n";
                                    
                                if( $mines[$i] == '*' ){
                                    // on a mine
                                    $grid[$i] = '*';
                                    // echo 'mine'."\n";
                                }
                                else{
                                    $cpt = 0;
                                    // empty square
                                    // how many mine around me?
                                    for($y=-1; $y <= 1; $y++){
                                        for($x=-1; $x <= 1; $x++){
                                            if( ($x!=0)||($y!=0) ){
                                                $test_x = $X+$x;
                                                $test_y = $Y+$y;
                                                if( ($test_x >= 0 && $test_x < $m) && ($test_y >= 0 && $test_y < $n) ){
                                                    $test_i = $test_x + $test_y * $m;
                                                    if( $mines[$test_i] == '*' ){
                                                        $cpt++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $grid[$i] = $cpt;
                                }
                            }
                            echo implode('',$grid)."\n";
                            
                        }
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