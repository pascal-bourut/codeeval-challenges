<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/139/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

$months = array(
    'Jan' => 1,
    'Feb' => 2,
    'Mar' => 3,
    'Apr' => 4,
    'May' => 5,
    'Jun' => 6,
    'Jul' => 7,
    'Aug' => 8,
    'Sep' => 9,
    'Oct' => 10,
    'Nov' => 11,
    'Dec' => 12
);

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $xp = array();
                        $total = 0;
                        $experiences = explode('; ',$line);
                        for($i=0,$cnt=count($experiences) ; $i < $cnt ; $i++){
                            list($from, $to) = explode('-',$experiences[$i]);
                            list($from_m, $from_Y) = explode(' ',$from);
                            list($to_m, $to_Y) = explode(' ',$to);
                            $begin = ($from_Y - 1990) * 12 + $months[$from_m];
                            $end = ($to_Y - 1990) * 12 + $months[$to_m];
                            for( $j = $begin ; $j <= $end ; $j++ ){
                                if( !isset($xp[$j]) ){
                                    $xp[$j] = true;
                                    $total++;
                                }
                            }
                        }
                        echo floor( $total / 12 )."\n";
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
