<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/144/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $last_digits = array();
                for($i=2;$i<=9;$i++){
                    $last_digits[$i] = array();
                    $d = $i;
                    $last_digits[$i][] = $d;
                    while(true){
                        $d = substr( $d * $i, -1);
                        if( in_array($d, $last_digits[$i]) ){
                            break;
                        }
                        else{
                            $last_digits[$i][] = $d;
                        }
                    }                    
                }//
                // print_r($last_digits);
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        list($a,$n) = explode(' ',$line);
                        $ld = $last_digits[$a];
                        $cnt = count($ld);
                       
                        $stats = array();
                        foreach($ld as $k => $v){
                            $nb = ceil(($n-$k) / $cnt);
                            $stats[ $v ] = $nb;
                        }
                        
                        $result = array();
                        for($i=0;$i<=9;$i++){
                            $result[] = $i.': '.( isset($stats[$i]) ? $stats[$i] : 0 );
                        }
                        echo implode(', ',$result)."\n";
                        /*
                        if( array_sum($stats) != $n ) {
                            echo 'ERR' . "\n";
                            for($i=1 ; $i <= $n ; $i++){
                                echo 'a^'.$i.'='.pow($a,$i)."\n";
                            }
                        }
                        */
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
