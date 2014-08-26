<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/86/

/*
High Card: Highest value card.
One Pair: Two cards of the same value.
Two Pairs: Two different pairs.
Three of a Kind: Three cards of the same value.
Straight: All cards are consecutive values.
Flush: All cards of the same suit.
Full House: Three of a kind and a pair.
Four of a Kind: Four cards of the same value.
Straight Flush: All cards are consecutive values of same suit.
Royal Flush: Ten, Jack, Queen, King, Ace, in same suit.
The cards are valued in the order:
2, 3, 4, 5, 6, 7, 8, 9, Ten, Jack, Queen, King, Ace.
*/

$combos = array(
    'royal_flush' => 9,
    'straight_flush' => 8,
    'four_of_a_kind' => 7,
    'full_house' => 6,
    'flush' => 5,
    'straight' => 4,
    'three_of_a_kind' => 3,
    'two_pairs' => 2,
    'one_pair' => 1,
    'high_card' => 0
);

$card_values = array(
    '2' => 1,
    '3' => 2,
    '4' => 3,
    '5' => 4,
    '6' => 5,
    '7' => 6,
    '8' => 7,
    '9' => 8,
    'T' => 9,
    'J' => 10,
    'Q' => 11,
    'K' => 12,
    'A' => 13
);    
    
function card_cmp($a, $b){
    global $card_values;
    if ($a[0] == $b[0]) {
        return 0;
    }
    
    return ($card_values[$a[0]] > $card_values[$b[0]]) ? -1 : 1;
}

function values_cmp($a, $b){
    if ($a['value'] == $b['value']) {
        return $b['key'] - $a['key'];
    }
    return  $b['value'] - $a['value'];
}

function get_value($cards){
    global $card_values, $combos;
    $cards_count = count($cards);
    usort($cards, 'card_cmp');
    // print_r($cards);
    $straight = true;
    $old_value = false;
    $colors = array(
        'H' => 0,
        'C' => 0,
        'S' => 0,
        'D' => 0,
    );
    $values = array();
    for($i=0;$i<$cards_count;$i++){
        $value = $cards[$i][0];
        $color = $cards[$i][1];
        
        $card_value = $card_values[$value];
        if( $old_value ){
            $straight &= (($old_value-$card_value)==1);
        }
        $old_value = $card_value;
    
        if( !isset($values[$card_value]) ){
            $values[$card_value] = 0;
        }
        $values[$card_value]++;
        $colors[$color]++;
    }
    
    $flush = false;
    foreach($colors as $k => $v){
        if( $v == 5 ){
            $flush = true;
            break;
        }
    }
    
    $tmp = $values;
    $values = array();
    foreach($tmp as $k => $v){
        $values[] = array('key'=>$k, 'value'=>$v);
    }
    usort($values, 'values_cmp');
    
    $kicker = 0;
    $combo = 'high_card';
    
    $highest_card = $cards[0][0];
    if( $flush ){
        if( $straight ){
            if( $highest_card == 'A' ){
                // royal flush !!!
                $combo = 'royal_flush';
                // no kicker (all royal flush are eqaully strong)
            }
            else{
                // straight flush !
                $combo = 'straight_flush';
                // kicker: highest card of the straight (first one)
                $kicker = $card_values[$highest_card];
            }
        }
        else{
            // flush!
            $combo = 'flush';
            
            // kicker : highest cards
            for($i=0, $cnt = count($values) ; $i < $cnt ; $i++){
                $k = $values[i]['key'];
                $kicker += pow(2, $k);
            }
        }
    }
    else if( $straight ){
        // straight!
        $combo = 'straight';
        // kicker: highest card of the straight (first one)
        $kicker = $card_values[ $highest_card ];
    }
    else{
        // four_of_a_kind
        if( $values[0]['value'] == 4 ){
            $combo = 'four_of_a_kind';
        }
        else if( $values[0]['value'] == 3 && $values[1]['value'] == 2 ){
            $combo = 'full_house';
        }
        else if( $values[0]['value'] == 3 ){
            $combo = 'three_of_a_kind';
        }
        else if( $values[0]['value'] == 2 && $values[1]['value'] == 2 ){
            $combo = 'two_pairs';
        }
        else if( $values[0]['value'] == 2 ){
            $combo = 'one_pair';
        }
        else{
            $combo = 'high_card';
        }
        
        // kicker
        for($i=0, $cnt = count($values) ; $i < $cnt ; $i++){
            $k = $values[$i]['key'];
            $kicker += $k * bcpow('10', ($cnt - $i - 1) * 2);
        }
        
    }
   
    $score = $combos[$combo];
    
    $kicker = str_pad($kicker, 10, '0', STR_PAD_LEFT);
    
    // echo $score.' '.$kicker."\n";
    
    return $score.$kicker;
    
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
                        $cards = explode(' ',$line);
                        $val_left = get_value( array_slice($cards, 0,5) );
                        $val_right = get_value( array_slice($cards, 5) );
                        /*
                        var_export($val_left);
                        echo ' vs ';
                        var_export($val_right);
                        */
                        $cmp = strcmp($val_left,$val_right);
                        if( $cmp < 0 ) echo 'right';
                        else if( $cmp > 0 ) echo 'left';
                        else echo 'none';
                        echo "\n";
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
