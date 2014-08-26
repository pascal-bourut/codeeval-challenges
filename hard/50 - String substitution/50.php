<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/50/

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
                        list($str,$sub) = explode(';',$line);
                        $sub = explode(',',$sub);
                        $replaced = array();
                        $first = ord('a');
                        for($i=0,$cnt=count($sub);$i<$cnt;$i+=2){
                            $replacement = chr($first+count($replaced));
                            $replaced[$replacement] = $sub[$i+1];
                            $str = str_replace($sub[$i], $replacement, $str);
                        }//
                        echo strtr($str, $replaced)."\n";
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
