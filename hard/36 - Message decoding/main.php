<?php
header('Content-Type: text/plain; charset=utf-8');

https://www.codeeval.com/open_challenges/36/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                // message = header+pattern
                // 0,00,01,10,000,001,010,011,100,101,110,0000,0001,. . .,1011,1110,00000, . . . 
                // 1 => len 1 (first = 0, next + 1) 2-1
                // 3 => len 2                       4-4
                // 7 => len 3                       8-1
                // 15 => len 4                      16-1
                // 
                $keys = array();
                $j = 0;
                for( $len = 1 ; $len <= 7 ; $len++ ){
                    $cnt = pow(2, $len) - 1;
                    for( $i = 0 ; $i < $cnt ; $i++ ){
                        if( !isset($keys[$len]) ){
                            $keys[$len] = array();
                        }
                        $keys[$len][str_pad(decbin($i),$len,'0',STR_PAD_LEFT)] = ($j++);
                    }
                } 
                // print_r($keys);

                // encoded message = 0 1 \r
                // message = x segments
                // segment = BBB  => segment key length
                // 010 => LN => 2 => keys of length 2 (00,01,10)
                // segment ends with  LN 1
                // whole message ends with 000
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $line = str_replace('\r','',$line);
                        
                        if( preg_match('/^([^0-1]+)([0-1]+)000$/',$line,$tokens) ){
                            $header = $tokens[1];
                            $content = $tokens[2];
                            $content = str_split($content,1);
                            $max = count($content);
                            
                            $eos = '';
                            $segment_header = '';
                            $key_len = 0;
                            $in_segment = false;
                            $decoded = '';
                            for( $i = 0 ; $i < $max ; ){
                                if( $in_segment ){
                                    $buf = '';
                                    for( $j = 0 ; $j < $key_len ; $j++ ){
                                        $buf .= $content[ $i + $j ];
                                    }
                                    if( $buf == $eos ){
                                        // end of segment
                                        $in_segment = false;
                                    }
                                    else{
                                        $decoded .= $header[ $keys[$key_len][$buf] ];
                                    }
                                    
                                    $i += $key_len;
                                }
                                else{
                                    $segment_header = $content[ $i ] . $content[ $i + 1 ] . $content[ $i + 2 ];
                                    $key_len = bindec($segment_header);
                                    $in_segment = true;
                                    $eos = str_repeat('1',$key_len);
                                    $i += 3;
                                }
                            }
                            echo $decoded."\n";
                            
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