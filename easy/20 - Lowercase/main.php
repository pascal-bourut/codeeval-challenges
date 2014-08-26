<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/20/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                // $i=0;
                while ( $fp && !feof( $fp ) ) {
                    $line = fgets($fp);
                    echo strtolower($line)."\r\n";
                }//
                fclose( $fp );
            }
            else{
                echo '!fp'."\r\n";
            }
        }
        else{
            echo '!readable'."\r\n";
        }
    }
    else{
        echo '!file_exists'."\r\n";
    }
}
else{
    echo '!argv[1]'."\r\n";
}

exit(0);

?>
