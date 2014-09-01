<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/150/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $romans = array(
                    'I' => 1,
                    'V' => 5,
                    'X' => 10,
                    'L' => 50,
                    'C' => 100,
                    'D' => 500,
                    'M' => 1000
                );
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        // echo $line."\n";
                        $old_r = 0;
                        $chars = str_split($line);
                        $i = count($chars);
                        $total = 0;
                        while( ($i-=2) >= 0 ){
                            $a = $chars[$i];
                            $r = $romans[$chars[$i+1]];
                            
                            // echo $a.'x'.$r."\n";
                            
                            if( $old_r > $r ){
                                // echo '-'."\n";
                                $total -= $a * $r;
                            }
                            else{
                                // echo '+'."\n";
                                $total += $a * $r;
                            }
                            $old_r = $r;
                            
                        }
                        echo $total."\n";
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
