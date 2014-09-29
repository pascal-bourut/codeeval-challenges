<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/163/

$tmp = '-**----*--***--***---*---****--**--****--**---**--
*--*--**-----*----*-*--*-*----*-------*-*--*-*--*-
*--*---*---**---**--****-***--***----*---**---***-
*--*---*--*-------*----*----*-*--*--*---*--*----*-
-**---***-****-***-----*-***---**---*----**---**--
--------------------------------------------------';

$tmp = explode("\n", $tmp);
$big_digits = array();
for($i = 0 ; $i < 6 ; $i++ ){
    $line = trim($tmp[$i]);
    for($j = 0 ; $j <= 9 ; $j++ ){
        $big_digits[$j][] = substr($line, $j * 5, 5);
    }
}

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line !== '' ){
                        $digits = preg_replace('/[^0-9]+/','',$line);
                        $result = '';
                        $len = strlen($digits);
                        
                        for($i = 0 ; $i < 6 ; $i++ ){
                            for( $j=0;  $j < $len ; $j++){
                                $result .= $big_digits[$digits[$j]][$i];
                            }
                            $result .= "\n";
                        }
                        echo $result;
                        
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
