<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/52/

$trans = array(
    '1' => 'One',
    '2' => 'Two',
    '3' => 'Three',
    '4' => 'Four',
    '5' => 'Five',
    '6' => 'Six',
    '7' => 'Seven',
    '8' => 'Eight',
    '9' => 'Nine',
    '10' => 'Ten',
    '11' => 'Eleven',
    '12' => 'Twelve',
    '13' => 'Thirteen',
    '14' => 'Fourteen',
    '15' => 'Fifteen',
    '16' => 'Sixteen',
    '17' => 'Seventeen',
    '18' => 'Eighteen',
    '19' => 'Nineteen',
    '20' => 'Twenty',
    '30' => 'Thirty',
    '40' => 'Forty',
    '50' => 'Fifty',
    '60' => 'Sixty',
    '70' => 'Seventy',
    '80' => 'Eighty',
    '90' => 'Ninety',
    'pow2' => 'Hundred',
    'pow5' => 'Hundred',
    'pow8' => 'Hundred',
    'pow3' => 'Thousand',
    'pow6' => 'Million',
    'pow9' => 'Billion',
    '$' => 'Dollars'
);

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets( $fp ));
                    if( $line ) {
                        // echo $line."\n";
                        $len = strlen($line);
                        $i = $len;
                        $result = '';
                        while( $i-- ){
                            
                            $pos = $len - $i - 1;
                            $modpos = $pos%3;
                            
                            $digit = $line[$i];
                            // echo $digit.': '.$pos."\n";
                            if( isset($trans['pow'.$pos]) ){
                                
                                if( $modpos == 2 ){
                                    if( isset($trans[$digit]) ){
                                        $result = $trans[$digit] . $trans['pow'.$pos] . $result; // Hundred
                                    }
                                }
                                else {
                                    if( intval(substr($line, -$pos-3, -$pos)) > 0 ){
                                        $result = $trans['pow'.$pos] . $result; // Thousand, Million    
                                    }
                                }
                            }
                            
                            if( $modpos == 0 ){
                                // 0, 3, 6, 9
                                
                                if( isset($line[$i-1]) ){
                                    $i--;
                                    $tens = $line[$i];
                                }
                                else{
                                    $tens = '0';
                                }
                                
                                // echo $digit.', '.$tens."\n";
                                
                                if( $digit == '0' ){
                                    if( $tens != '0' ){ // e.g.: 10, 30, 60
                                        $result = $trans[$tens.$digit].$result;
                                    }
                                }
                                else{
                                    if( $tens == '0' ){  // e.g.: 01, 03, 06
                                        $result = $trans[$digit].$result;
                                    }
                                    else if( $tens == '1' ){ // e.g.: 11, 13, 16
                                        $result = $trans['1'.$digit].$result;
                                    }
                                    else{ // e.g.: 23, 46, 79
                                        $result = $trans[$tens.'0'].$trans[$digit].$result;
                                    }
                                }
                            }
                            
                        }
                        echo $result.$trans['$']."\n";
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
