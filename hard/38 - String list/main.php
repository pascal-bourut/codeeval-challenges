<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/38/

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
                        $out = '';
                        list($n, $s) = explode(',', $line);
                        $base = array_unique(str_split($s,1));
                        rsort($base);
                        $base_cnt = count($base);
                        /*
                        echo '$base_cnt:'.$base_cnt."\n";
                        echo '$s:'.$s."\n";
                        echo '$n:'.$n."\n";
                        */
                        if( $base_cnt == 1 ){
                            $out .= str_repeat($base[0], $n);
                        }
                        else{
                            $max = base_convert( str_repeat($base_cnt-1,$n), $base_cnt, 10);
                            // echo '$max:'.$max."\n";
                            $i = $max+1;
                            while($i--){
                                $test = str_pad(base_convert($i, 10, $base_cnt),$n,'0',STR_PAD_LEFT);
                                $out .= strtr($test,$base).',';
                            }
                        }
                        echo rtrim($out,',')."\n";
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