<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/124/

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
                        $cities = explode('; ', trim($line,';'));
                        $nb = count($cities);
                        for($i=0;$i<$nb;$i++){
                            list($name, $distance) = explode(',', $cities[$i]);
                            $cities[ $i ] = $distance;
                        }
                        sort($cities);
                        
                        $current = 0;
                        $result = array();
                        for($i=0;$i<$nb;$i++){
                            $result[] = $cities[$i] - $current;
                            $current = $cities[$i];
                        }
                        echo implode(',',$result)."\n";
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
