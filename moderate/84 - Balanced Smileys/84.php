<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/84/

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
                        $min_open = 0;
                        $max_open = 0;
        
                        for($i=0, $len = strlen($line) ; $i < $len ; $i++){
                            $c = $line[ $i ];
                            if( $c == '(' ){
                                // opening parenthesis (or maybe second char of a frowny face)
                                $max_open++;
                                if( $i===0 || $line[$i-1] != ':' ){
                                    // first character or doesn't form a smiley with the previous character
                                    $min_open++;
                                }
                            }
                            else if( $c==')' ){
                                // closing parenthesis (or maybe second char of a smiley face)
                                if( $min_open > 0 ){
                                    $min_open--;
                                }
                                
                                if( $i===0 || $line[$i-1] != ':' ){
                                    // first character or doesn't form a smiley with the previous character 
                                    $max_open--;
                                }
                                
                                if( $max_open < 0 ){
                                    // closing parenthesis with not opening one
                                    break;
                                }
                                
                            }
                        }
                        //
                        echo ( ($max_open>=0 && $min_open===0) ? 'YES' : 'NO' )."\n";
                    }//
                    
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
