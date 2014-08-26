<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/browse/13/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                // Q: programming first The language;3 2 1
                // A: The first programming language
                
                // 3 => programmaing
                // 2 => first
                // 1 => The
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        list($words, $hints) = explode(';', $line);
                        $words = explode(' ',$words);
                        $hints = explode(' ',$hints);
                        
                        $trans = array();
                        foreach($hints as $order => $index){
                            $trans[ $index ] = $words[ $order ];
                        }
                        
                        $out = '';
                        for($i=1 ; $i <= count($hints) + 1 ; $i++){
                            $out .= ( isset($trans[$i]) ? $trans[$i] : $words[ count($words) - 1] ) . ' ';
                        }
                        
                        echo rtrim($out)."\n";
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

/*
programming first The language;3 2 1
    
The first programming language
2 1 0 3
    
2000 and was not However, implemented 1998 it until;9 8 3 4 1 5 7 2 
However, it was not implemented until 1998 and 2000
4 7 2 3 5 8 6 1 0 

programs Manchester The written ran Mark 1952 1 in Autocode from;6 2 1 7 5 3 11 4 8 9
The Manchester Mark 1 ran programs written in Autocode from 1952

2 1 5 7 4 0 3 8 9 10 6 
*/
?>
