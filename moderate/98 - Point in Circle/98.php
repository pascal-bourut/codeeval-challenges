<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/98/

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
                        if( preg_match('/^Center: \(([0-9\-\.]+), ([0-9\-\.]+)\); Radius: ([0-9\-\.]+); Point: \(([0-9\-\.]+), ([0-9\-\.]+)\)$/',$line, $matches) ){
                            $center_x = $matches[1];
                            $center_y = $matches[2];
                            $radius = $matches[3];
                            $point_x = $matches[4];
                            $point_y = $matches[5];
                            
                            $square_distance = ( $center_x - $point_x ) * ( $center_x - $point_x ) + ( $center_y - $point_y ) * ( $center_y - $point_y );
                            echo ( ($square_distance <= $radius*$radius) ? 'true' : 'false' ) . "\n";
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
