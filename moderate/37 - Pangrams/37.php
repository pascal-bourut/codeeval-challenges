<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/37/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $a = ord('a');
                $z = ord('z');
                for($i=$a; $i<=$z; $i++){
                    $trans[chr($i)] = 1;
                }
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $line = strtolower($line);
                        $letters = $trans;
                        $i = strlen($line);
                        while($i--){
                            unset($letters[$line[$i]]);        
                        }
                        echo ( $letters ? implode('',array_keys($letters)) : 'NULL' ) . "\n";
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
