<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/69/
             
function process($str, $sub, $depth, $pos){
    // echo 'process(',$str,',',$sub,',',$depth,',',$pos,')',"\n";
    
    $count = 0;
    
    // find $sub[$depth] into $str with starting point >= $pos
    $needle = $sub[ $depth ];
    $len = strlen($str);
    $sublen = strlen($sub);
    
    // echo 'find ',$needle,' into ',$str,' from pos ', $pos."\n";
    
    for( $i = $pos ; $i < $len ; $i++ ){
        // echo 'test ',$str[$i],"\n";
        if( $str[$i] == $needle ){
            // echo $needle.' at '.$i."\n";
            if( $depth < ($sublen-1) ){
                $count += process($str, $sub, $depth+1, $i+1);
            }
            else{
                $count ++;
            }
        }
    }
    
    return $count;
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
                    if( $line ){
                        list($str,$sub) = explode(',',$line);
                        // echo 'str:',$str,',sub:',$sub,"\n";
                        echo process($str,$sub,0,0)."\n";
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