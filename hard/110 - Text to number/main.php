<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/110/

/*
two hundred twenty one million four hundred fifty seven thousand four hundred fifteen
number=0
fifteen: 0+15   pow=0         => 15
hundred:        pow=2         => 15
four:    15 + 4*10^2   pow=2  => 415
thousand: 3>2  pow=3          => 415
seven:    415 + 7*10^3  pow=3 => 7415
fifty:    7415 + 50*10^3 pow=3 => 57415
hundred:  2<3  pow=3+2  pow=5  => 57415
four:     57415 + 4*10^5 => 57415+400000 => 457415
million:  6>5  pow=6  => 457415
one:      457415 + 1*10^6   => 1457415
tweenty:  1457415 + 20*10^6  => 21457415 
hundred:  2<6 pow=6+2  pow=8   => 21457415 
two:      21457415 + 2+10^8   => 21457415+200000000  => 221457415
*/

$small_numbers = array(
    'zero' => 0,
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
    'ten' => 10,
    'eleven' => 11, 
    'twelve' => 12, 
    'thirteen' => 13, 
    'fourteen' => 14, 
    'fifteen' => 15, 
    'sixteen' => 16, 
    'seventeen' => 17, 
    'eighteen' => 18, 
    'nineteen' => 19,
    'twenty' => 20,
    'thirty' => 30,
    'forty' => 40,
    'fifty' => 50,
    'sixty' => 60,
    'seventy' => 70,
    'eighty' => 80,
    'ninety' => 90
);
$large_numbers = array(
    'hundred' => 2,
    'thousand' => 3,
    'million' => 6
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
                        $words = explode(' ', $line);
                        $max = count($words);
                        $i = $max;
                        $result = 0;
                        $pow = 0;
                        while($i--){
                            
                            if( isset($small_numbers[$words[$i]]) ){
                                $result +=  $small_numbers[$words[$i]] * pow(10,$pow);
                            }
                            else if( isset($large_numbers[$words[$i]]) ){
                                if( $large_numbers[$words[$i]] > $pow ){
                                    $pow = $large_numbers[$words[$i]];
                                }
                                else{
                                    $pow += $large_numbers[$words[$i]];
                                }
                            }
                            else if( 'negative' == $words[$i] ){
                                $result = -$result;
                            }
                        }
                        echo $result."\n";
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
