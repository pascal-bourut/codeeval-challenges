<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/70/

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
                        // The co-ordinates are upper left x of A, upper left y of A, lower right x of A, lower right y of A, upper left x of B, upper left y of B, lower right x of B, lower right y of B. E.g.
                        list($upper_left_x_a, $upper_left_y_a, $lower_right_x_a, $lower_right_y_a,$upper_left_x_b, $upper_left_y_b, $lower_right_x_b, $lower_right_y_b) = explode(',',$line);
                        $intersect = false;
                        if( $upper_left_x_a > $lower_right_x_b || $upper_left_x_b > $lower_right_x_a ){
                            $intersect = false;
                        }
                        else if( $upper_left_y_a < $lower_right_y_b || $upper_left_y_b < $lower_right_y_a ){
                            $intersect = false;
                        }
                        else{
                            $intersect = true;
                        }
                        echo ( $intersect ? 'True' : 'False' ) . "\n";
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
