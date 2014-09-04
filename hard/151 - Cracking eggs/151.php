<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/151/

// n + (n-1) + (n-2) + (n-3) + (n-4) + … + 1  >=  100
// n (n+1) / 2  >=  100
// 13.651 => 14

// http://datagenetics.com/blog/july22012/index.html

function get_maximum_floors( $eggs, $drop_count){
    if ($eggs === 0) {
        return 0;
    }
    else{
        $result = 0;
        for ($i = 0; $i < $drop_count; $i++){
            $result += get_maximum_floors( $eggs - 1, $i) + 1;
        }
        return $result;
    }
}

function cracking_eggs( $eggs, $floors){
    $drops_count = 0;
    while (get_maximum_floors($eggs, $drops_count) < $floors){
        $drops_count++;
    }
    return $drops_count;
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
                        list($eggs,$floors) = explode(' ',$line);
                        echo cracking_eggs( $eggs, $floors )."\n";        
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
