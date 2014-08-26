<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/browse/75/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line!=='' ){
                        list($n,$m) = explode(',',$line);
                        $people = array_fill(0,$n,true);
                        $next = ($m - 1);
                        $killings = '';
                        for($i = 0 ; $i < $n ; $i++){
                            // echo $i."\n";
                            if( $next == $i ){
                                if( $killings!='' ){
                                    $killings .= ' ';
                                }
                                $killings .= $i;
                                $people[$i] = false;
                                
                                $k = $m;
                                for( $j=0; $j < $n*$m ; $j++ ){
                                    $idx = ($i + $j) % $n;
                                    if( $people[$idx] ){
                                        if( --$k == 0 ){
                                            $next = $idx;
                                            $i = -1;
                                            break;
                                        }
                                    }
                                }   
                            }
                        }
                        echo $killings."\n";
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
