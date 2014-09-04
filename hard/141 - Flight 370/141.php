<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/141/


function distance($lat1, $lng1, $lat2, $lng2){
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;

    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat * 0.5) * sin($dlat * 0.5) + cos($lat1) * cos($lat2) * sin($dlng * 0.5) * sin($dlng * 0.5);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;

	return $km;
}//

function placemark_cmp($a,$b){
    if( $a['nb'] == $b['nb'] ){
        if( $a['ts'] > $b['ts'] ) return -1;
        if( $a['ts'] < $b['ts'] ) return 1;
        if( $a['ts'] == $b['ts'] ) return $a['id'] - $b['id'];
    }
    return $b['nb'] - $a['nb'];
}

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $in_xml = false;
                $regions = array();
                $placemarks = array();
                $in_placemark = false;
                
                $id = $nb = $lon = $lat = $ts = 0;
                $name = '';
                
                /*
                $cpt = 100;
                */
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                
                
                    /*
                    echo $line."\n";
                    if( $cpt-- < 0 ){
                        die();
                    }
                    */
                    
                    if( $line ){
                        if( false !== strpos($line, '<?xml version="1.0"')  ){
                            $in_xml = true;
                        }
                        else if( $in_xml ){
                            $pos = strpos($line,'Placemark');
                            if( $pos !== false ){
                                $c = $line[$pos-1];
                                if( $c == '<' ){
                                    $in_placemark = true;
                                    $id = substr($line, $pos+14, strrpos($line,'"') - $pos - 14);
                                }
                                else if( $c == '/' ){
                                    $in_placemark = false;
                                    // print_r($placemark);
                                    $placemarks[] = array(
                                        'id' => $id,
                                        'name' => $name,
                                        'ts' => $ts,
                                        'lon' => $lon,
                                        'lat' => $lat,
                                        'nb' => $nb
                                    );
                                    $id = $nb = $lon = $lat = $ts = 0;
                                    $name = '';
                                }
                            }
                            else if( $in_placemark ){
                                /*
                                if( preg_match('/<name>([^<]+)<\/name>/', $line, $matches )) {
                                    $placemark['name'] = $matches[1];
                                }
                                else if( preg_match('/Confirmation: <b>([^<]+)<\/b>/', $line, $matches )) {
                                    $placemark['nb'] = $matches[1];
                                }
                                else if( preg_match('/<TimeStamp><when>([^<]+)<\/when><\/TimeStamp>/', $line, $matches )) {
                                    $placemark['ts'] = $matches[1];
                                }
                                else if( preg_match('/<Point><coordinates>([\-0-9\.]+),([\-0-9\.]+)<\/coordinates><\/Point>/', $line, $matches )) {
                                    $placemark['lon'] = $matches[1];
                                    $placemark['lat'] = $matches[2];
                                }
                                */
                                
                                if( ( false !== ($from = strpos($line,'<name>'))) && ( false !== ($to = strpos($line,'</name>',$from))) ){
                                    $name = substr($line, $from+6, $to-$from-6);
                                }
                                else if( ( false !== ($from = strpos($line,'Confirmation: <b>'))) && ( false !== ($to = strpos($line,'</b>',$from))) ){
                                    $nb = substr($line, $from+17, $to-$from-17);
                                }
                                else if( ( false !== ($from = strpos($line,'<TimeStamp><when>'))) && ( false !== ($to = strpos($line,'</when></TimeStamp>',$from))) ){
                                    $ts = substr($line, $from+17, $to-$from-17);
                                }
                                else if( ( false !== ($from = strpos($line,'<Point><coordinates>'))) && ( false !== ($to = strpos($line,'</coordinates></Point>',$from))) ){
                                    list($lon,$lat) = explode(',', substr($line,$from+20, $to-$from-20));
                                }
                                
                            }
                        }
                        else {
                            $tmp = preg_split('/[;\(\) ,]+/',$line);
                            $regions[] = array(
                                'km' => $tmp[0],
                                'lon' => $tmp[1],
                                'lat' => $tmp[2]
                            );
                        }
                    }
                    
                }//
                fclose( $fp );
                
                /*
                $xml = simplexml_load_string($xml_str);
                $xml->registerXPathNamespace('kml', 'http://www.opengis.net/kml/2.2');
                $placemarks = $xml->xpath('//kml:Placemark');
                */
                
                $regions_cnt = count($regions);
                $placemarks_cnt = count($placemarks);
                /*
                echo '$regions_cnt: ' . $regions_cnt."\n";
                echo '$placemarks_cnt: ' . $placemarks_cnt."\n";
                */
                
                usort($placemarks,'placemark_cmp');
                
                for($i=0 ; $i < $regions_cnt ; $i++){
                    $km = $regions[$i]['km'];
                    $lng1 = $regions[$i]['lon'];
                    $lat1 = $regions[$i]['lat'];
                    
                    $max = 0;
                    $placemarks_ok = array();
                    for($j=0 ; $j < $placemarks_cnt ; $j++){
                        $placemark = $placemarks[$j];
                        $lng2 = $placemark['lon'];
                        $lat2 = $placemark['lat'];
                        $nb = $placemark['nb'];
                        if( $nb >= $max ){
                            if( distance($lat1, $lng1, $lat2, $lng2) <= $km ){
                                if( $nb > $max ){
                                    $placemarks_ok = array();
                                }
                                $placemarks_ok[] = $placemark;
                                $max = $nb;
                            }
                        }
                        else{
                            break;
                        }
                    }
                    if( $placemarks_ok ){
                        for($k=0, $cnt = count($placemarks_ok) ; $k < $cnt ; $k++){
                            echo ( $k > 0 ? ', ' : '' ) . $placemarks_ok[$k]['name']/*.'('.$placemarks_ok[$k]['nb'].','.$placemarks_ok[$k]['ts'].','.$placemarks_ok[$k]['id'].')'*/;
                        }
                    }
                    else{
                        echo 'None';
                    }
                    echo "\n";
                }
                
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

