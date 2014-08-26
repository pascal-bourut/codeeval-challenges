<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/2/
if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function by_length($a,$b){
    return strlen($b)-strlen($a);
}

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $lines = array();
                $count = false;
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        if( $count === false ){
                            $count = $line;
                        }
                        else{
                            $lines[] = $line;
                        }
                    }
                }//
                fclose( $fp );
                
                usort($lines,'by_length');
                for($i=0;$i<$count;$i++){
                    echo $lines[$i]."\n";
                }
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
