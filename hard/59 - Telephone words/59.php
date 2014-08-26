<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/59/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

$trans = array(
    0 => array('0'),
    1 => array('1'),
    2 => array('a','b','c'),
    3 => array('d','e','f'),
    4 => array('g','h','i'),
    5 => array('j','k','l'),
    6 => array('m','n','o'),
    7 => array('p','q','r','s'),
    8 => array('t','u','v'),
    9 => array('w','x','y','z'),
);

function phone_to_word($str, $idx=0, $histo = '', &$words = array() ){
    global $trans/*, $all*/;
    
    if( isset($str[$idx]) ){
        $c = $str[$idx];
        $letters = $trans[$c];
        for($i=0, $cnt=count($letters) ; $i < $cnt ; $i++){
            phone_to_word($str, $idx+1, $histo.$letters[$i], $words);
        }
    }
    else{
        $words[] = $histo;
    }
};

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $all = array();
                        phone_to_word($line, 0, '', $all);
                        echo implode(',', $all)."\n";
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
