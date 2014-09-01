<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/5/

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
                        $tmp = explode(' ',$line);
                        $cnt = count($tmp);
                        $i = $cnt;
                        $streak = array();
                        while($i--){
                            $j = $i;
                            while($j--){
                                $tmp_i = $tmp[$i];
                                $tmp_j = $tmp[$j];
                                if( $tmp_i == $tmp_j ){
                                    $si = $i;
                                    $sj = $j;
                                    $streak[] = $tmp_i;
                                    for($k = 1, $max = ($i < $j ? $i : $j) ; $k <= $max ; $k++){
                                        $tmp_i_k = $tmp[$si-$k];
                                        $tmp_j_k = $tmp[$sj-$k];
                                        if( $tmp_i_k == $tmp_j_k ){
                                            if( false === in_array($tmp_i_k, $streak) ){
                                                $streak[] = $tmp_i_k;
                                            }
                                            $i--;
                                            $j--;
                                        }
                                        else{
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                        echo implode(' ',array_reverse($streak))."\n";
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
