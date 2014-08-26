<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/120/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets( $fp ));
                    if( $line ) {
                        $buildings = explode(';',$line);
                        $len = count($buildings);
                        $height_at_x = array();
                        $i = $len;
                        $min = 10001;
                        $max = 0;
                        while($i--){
                            $tmp = explode(',',trim($buildings[$i],' ()'));
                            for( $x = $tmp[0] ; $x < $tmp[2] ; $x++ ){
                                if( !isset($height_at_x[$x]) || ($tmp[1] > $height_at_x[$x]) ){
                                    $height_at_x[$x] = $tmp[1];
                                }
                            }
                            if( $tmp[0] < $min ) $min = $tmp[0];
                            if( $tmp[2] > $max ) $max = $tmp[2];
                        }
                        
                        $result = '';
                        $old_h = 0;
                        // $keys = array_keys($height_at_x);
                        // $min = min($keys);
                        // $max = max($keys) + 1;
                        $max = $max + 1;
                        for( $i = $min ; $i <= $max ; $i++){
                            $h = isset($height_at_x[$i]) ? $height_at_x[$i] : 0;
                            if( $h != $old_h ){
                                $result .= $i.' '.$h.' ';
                                $old_h = $h;
                            }
                        }
                        
                        echo trim($result)."\n";
                       
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
