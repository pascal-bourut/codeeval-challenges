<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/143/

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
                        list($a,$b) = explode(';', $line);
                        $a_len = strlen($a);
                        $b = explode(' ',$b);
                        $offset = -1;
                        $pos = -1;
                        $found = 0;
                        $len = count($b);
                        for($i=0; $i < $len ; $i++){
                            if( $b[$i] && false !== ( $pos = strpos($a, $b[$i], $offset+1 ) ) ){
                                $b_len = strlen($b[$i]);
                                for($j = max(0,$offset) ; $j < $pos ; $j++){
                                    if( $a[$j] != ' ' ){
                                        $a[$j] = '_';
                                    }
                                    else{
                                        $a[$j] = ' ';
                                    }
                                }
                                
                                $offset = $pos + $b_len;
                                $found++;
                            }
                        }
                        if( $found && $found == $len ){
                            for($j = $offset ; $j < $a_len ; $j++){
                                if( $a[$j] != ' ' ){
                                    $a[$j] = '_';
                                }
                                else{
                                    $a[$j] = ' ';
                                }
                            }
                            $a = str_replace('  ',' ',$a);
                            $a = str_replace('  ',' ',$a);
                            $a = str_replace('  ',' ',$a);
                            echo $a."\n";
                        }
                        else{
                            echo 'I cannot fix history'."\n";
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
