<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/10/

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
                        $tmp = explode(' ',$line);
                        $len = count($tmp);
                        $nth = false;
                        $i = $len;
                        while($i--){
                            if( $nth === false ){
                                $nth = $tmp[$i];
                                if( $nth >= $len ){
                                    break;
                                }
                                else{
                                    $nth = $len - $nth - 1;
                                }
                            }
                            else if( $i == $nth ){
                                echo $tmp[$i]."\n";
                                break;
                            }
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
