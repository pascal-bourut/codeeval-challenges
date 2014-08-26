<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/40/

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
                        $counts = array_fill(0,9,0);
                        for($i=0; $i < $len ; $i++){
                            $counts[$line[$i]]++;
                        }
                        $is_sd = true;
                        for($i=0; ($i < $len) && $is_sd; $i++){
                            // Position '0' has value 2 and there is two 0 in the number.
                            // Position '1' has value 0 because there are not 1's in the number. 
                            // echo $counts[$i] . ' vs '.$line[$i]."\n";
                            $is_sd = $is_sd && ($counts[$i] == $line[$i]);
                        }
                        echo ($is_sd ? 1 : 0)."\n";
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
