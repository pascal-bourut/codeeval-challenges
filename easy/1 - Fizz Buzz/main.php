<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/browse/13/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                // $i=0;
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        list($a, $b, $n) = explode(' ',$line);
                        
                        $out = '';
                        for($i = 1; $i <= $n ; $i++){
                            $fb = (($i%$a == 0)?'F':'').(($i%$b == 0)?'B':'');
                            $out .= ' '.($fb?$fb:$i);
                        }
                        echo ltrim($out)."\n";
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
