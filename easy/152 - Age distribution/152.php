<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/152/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

$categories = array(
    "The Golden Years" => 100,
    "Working for the man" => 65,
    "College" => 22,
    "High school" => 18,
    "Middle school" => 14,
    "Elementary school" => 11,
    "Preschool Maniac" => 4,
    "Still in Mama's arms" => 2,
);

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line!=='' ){
                        $age = intval($line);
                        $out = '';
                        if( $age < 0 || $age > 100 ){
                            $out = 'This program is for humans';
                        }
                        else{
                            foreach($categories as $category => $age_max ){
                                if( $age <= $age_max ) {
                                    $out = $category;
                                }
                                else{
                                    break;
                                }
                            }
                        }
                        echo $out."\n";
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
