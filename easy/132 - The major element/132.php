<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/132/

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
                        $numbers = explode(',',$line);  
                        $count = array();
                        $nb = count($numbers);
                        for($i=0;$i<$nb;$i++){
                            if( !isset($count[$numbers[$i]]) ){
                                $count[ $numbers[$i] ] = 0;
                            }
                            $count[ $numbers[$i] ]++;
                        }
                        arsort($count);
                        
                        list($number, $times) = each($count);
                        if( $times > $nb/2 ){
                            echo $number . "\n";
                        }
                        else{
                            echo 'None' . "\n";
                        }
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
