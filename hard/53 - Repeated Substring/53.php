<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/53/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function biggest_repeating($phrase) {
    $most_used_phrase="";
	$length=0;

	for ($i = 0; $i < strlen($phrase); $i++) {
		for ($j = 0; $j < strlen($phrase)-$i+1; $j++) {
			$current_phrase = substr($phrase,$i,$j);
			if ($current_phrase != "") {
				if (strlen($current_phrase) > $length) {
                    $substr_count = substr_count($phrase,$current_phrase);
                    // echo 'substr_count('.$phrase.','.$current_phrase.') = '.$substr_count."\n";
					if ($substr_count > 1) {
						$most_used_phrase=$current_phrase;
						$length=strlen($current_phrase);
					}
				}
            }
		}
	}
	if (str_replace(" ","",$most_used_phrase)=="") {
		$most_used_phrase="NONE";
	}
	return $most_used_phrase;
}

/*
echo biggest_repeating('banana')."\r\n";
echo biggest_repeating('am so uniqe')."\r\n";
die();
*/

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = fgets( $fp );
                    echo biggest_repeating( trim($line) )."\r\n";
                }//
                fclose( $fp );
            }
            else{
                echo '!fp'."\r\n";
            }
        }
        else{
            echo '!readable'."\r\n";
        }
    }
    else{
        echo '!file_exists'."\r\n";
    }
}
else{
    echo '!argv[1]'."\r\n";
}

exit(0);

?>
