<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/85/

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
                        // echo $line."\n";
                        list($n,$k,$a,$b,$c,$r) = explode(',', $line);
                        $m = array();
                        $m[0] = $a;
                        for($i=1; $i < $k ; $i++){
                            $m[] = ($b * $m[$i-1] + $c) % $r;
                        }
                       
                        for( $i = $k; $i < $n ; $i++){
                            
                            $sub = array_slice($m, $i-$k, $k);
                            $sub = array_flip($sub);
                            
                            $min = 0;
                            // while( in_array($min,$sub) ){
                            while( isset($sub[$min]) ){
                                $min++;
                            }
                            // echo 'min:'.$min."\n";
                            $m[] = $min;
                            
                        }//
                        
                        echo $m[$n-1] . "\n";
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
