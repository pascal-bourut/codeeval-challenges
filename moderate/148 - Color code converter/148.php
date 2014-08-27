<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/148/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function hsl_to_rgb($hsl){
    list($h,$s,$l) = $hsl;
    
    $s /= 100;
    $l /= 100;
    
    $c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
	$x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
	$m = $l - ( $c / 2 );

	if ( $h < 60 ) {
		$r = $c;
		$g = $x;
		$b = 0;
	} else if ( $h < 120 ) {
		$r = $x;
		$g = $c;
		$b = 0;			
	} else if ( $h < 180 ) {
		$r = 0;
		$g = $c;
		$b = $x;					
	} else if ( $h < 240 ) {
		$r = 0;
		$g = $x;
		$b = $c;
	} else if ( $h < 300 ) {
		$r = $x;
		$g = 0;
		$b = $c;
	} else {
		$r = $c;
		$g = 0;
		$b = $x;
	}

	$r = ( $r + $m ) * 255;
	$g = ( $g + $m ) * 255;
	$b = ( $b + $m  ) * 255;

    return array( 'r' => round($r), 'g' => round($g), 'b' => round($b) );
}//hsl_to_rgb

function hsv_to_rgb($hsv){
    // echo 'hsv_to_rgb(' . var_export($hsv,true) . ')' . "\n";
    
    list($h, $s, $v) = $hsv;
    $s /= 100;
    $v /= 100;
    
    $c = $v * $s;
	$x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
	$m = $v - $c;

	if ( $h < 60 ) {
		$r = $c;
		$g = $x;
		$b = 0;
	} else if ( $h < 120 ) {
		$r = $x;
		$g = $c;
		$b = 0;			
	} else if ( $h < 180 ) {
		$r = 0;
		$g = $c;
		$b = $x;					
	} else if ( $h < 240 ) {
		$r = 0;
		$g = $x;
		$b = $c;
	} else if ( $h < 300 ) {
		$r = $x;
		$g = 0;
		$b = $c;
	} else {
		$r = $c;
		$g = 0;
		$b = $x;
	}

	$r = ( $r + $m ) * 255;
	$g = ( $g + $m ) * 255;
	$b = ( $b + $m  ) * 255;

    return array( 'r' => round($r), 'g' => round($g), 'b' => round($b) );
}//hsv_to_rgb

function cmyk_to_rgb($cmyk){
    // echo 'cmyk_to_rgb(' . var_export($cmyk,true) . ')' . "\n";
    
    list($c, $m, $y, $k) = $cmyk;
    
    $r	= (1 - ($c * (1 - $k)) - $k ) * 255;
 	$g	= ( 1 - ($m * (1 - $k)) - $k ) * 255;
 	$b	= ( 1 - ($y * (1 - $k)) - $k ) * 255;
      
    if($r<0) $r = 0 ;
    if($g<0) $g = 0 ;
    if($b<0) $b = 0 ;
      
    return array('r' => round($r), 'g' => round($g), 'b' => round($b) );
}//cmyk_to_rgb

function hex_to_rgb($hex){
    // echo 'hex_to_rgb(' . $hex . ')' . "\n";
    $int = hexdec($hex);
    return array('r' => 0xFF & ($int >> 0x10), 'g' => 0xFF & ($int >> 0x8), 'b' => 0xFF & $int);
}//hex_to_rgb

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        // echo ' => '. $line."\n";
                        $rgb = false;
                        if( strpos($line,'#') === 0 ){
                            // hex
                            $rgb = hex_to_rgb(substr($line,1));
                        }
                        else if( preg_match('/^(HSL|HSV|RGB|)?\((.*)\)$/',$line,$matches) ){
                            $c = explode(',',$matches[2]);
                            switch($matches[1]){
                                case 'HSL' : 
                                $rgb = hsl_to_rgb($c);
                                break;
                                case 'HSV' : 
                                $rgb = hsv_to_rgb($c);
                                break;
                                case '' : 
                                $rgb = cmyk_to_rgb($c);
                                break;
                            }//
                        }
                        if( $rgb ){
                            echo 'RGB('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].')' . "\n";
                        }//
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