<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/156/

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
                        $len = strlen($line);
                        $upper = 0;
                        $A = ord('A');
                        $Z = ord('Z');
                        $i = $len;
                        while($i--){
                            $ord = ord($line[$i]);
                            if( $ord >= $A && $ord <= $Z ){
                                $upper++;
                            }
                        }
                        echo 'lowercase: ' . number_format(($len-$upper)*100/$len, 2) . ' uppercase: ' . number_format(($upper*100)/$len, 2) . "\n";
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
