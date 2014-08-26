<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/44/

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
                        // echo $line."\n";
                        $len = strlen($line);
                        $i = $len;
                        $digits = array();
                        $prev = 0;
                        $result = '';
                        // I travel across the string right to left
                        while($i--){
                            $curr = $line[$i];
                            if( $curr >= $prev ){
                                // if current element bigger than prev element, I keep this for later into [digits]
                                $digits[] = $curr;
                                $prev = $curr;
                            }
                            else{
                                // if current element lower than prev element
                                // I will switch this element with the lowest of [digits]
                                sort($digits);
                                $min = $prev;
                                $idx = 0;
                                for( $j = 0, $nb = count($digits) ; $j < $nb ; $j++ ){
                                    $digit = $digits[$j];
                                    if( $digit > $curr ){ // lowest but bigger than current element though
                                        $min = $digit;
                                        $idx = $j;
                                        break;
                                    }
                                }
                                $digits[$idx] = $curr;
                                // result : unparsed digits + min + other digits ordered
                                $result = substr($line, 0, $i) . $min . implode('', $digits);
                                break;
                            }
                        }
                        
                        if( !$result ){
                            // no result
                            // I look for the lower digit by not zero
                            // result will be: lower + 0 + other digits ordered
                            sort($digits);
                            for($i=0, $nb = count($digits) ; $i < $nb ; $i++){
                                $digit = $digits[$i];
                                if( $digit > 0 ){
                                    unset($digits[$i]);
                                    $result = $digit . '0' . implode('', $digits);        
                                    break;
                                }
                            }
                        }
                        
                        echo $result."\n";
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