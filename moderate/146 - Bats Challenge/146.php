<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/146/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $margin = 6;
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $tmp = explode(' ', $line);
                        $wire = array_shift($tmp);
                        $d = array_shift($tmp);
                        $cnt = array_shift($tmp);
                        $bats = $tmp;
                        $from = $margin;
                        $count = 0;
                        // echo $wire.' '.$d.' '.$cnt.' '.var_export($bats, true)."\n";
                        for($i=0;$i<$cnt;$i++){
                            $bat = $bats[$i];
                            $to = $bat - $d;
                            // echo $i.': '.$to .'-'.$from.'='.floor(($to - $from) / $d) . "\n";
                            
                            if( $to >= $from ){
                                $count += floor(($to - $from) / $d) + 1;
                            }
                            
                            $from = $bat + $d;
                        }
                        $to = $wire - $margin;
                        // echo 'last: '. $to.'-'.$from.'='.floor(($to - $from) / $d) . "\n";
                        if( $to >= $from ){
                            $count += floor(($to - $from) / $d) + 1;
                        }
                        echo $count."\n";
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
