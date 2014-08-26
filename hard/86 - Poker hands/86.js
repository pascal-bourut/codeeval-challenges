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

var combos = {
    'royal_flush': 9,
    'straight_flush': 8,
    'four_of_a_kind': 7,
    'full_house': 6,
    'flush':  5,
    'straight':  4,
    'three_of_a_kind': 3,
    'two_pairs':  2,
    'one_pair':  1,
    'high_card':  0
};

var card_values = {
    '2': 1,
    '3': 2,
    '4': 3,
    '5': 4,
    '6': 5,
    '7': 6,
    '8': 7,
    '9': 8,
    'T': 9,
    'J': 10,
    'Q': 11,
    'K': 12,
    'A': 13
};    

var values_sort = function(obj) {
    var arr = [];
    for (var prop in obj) {
        if (obj.hasOwnProperty(prop)) {
            arr.push({
                'key': prop,
                'value': obj[prop]
            });
        }
    }
    arr.sort(function(a, b) { 
        var i = 0;
        if( b.value == a.value ){
            return b.key - a.key;
        }
        return b.value - a.value; 
    });
    return arr; // returns array
};

var card_cmp = function(a, b){
    if (a.charAt(0) == b.charAt[0]) {
        return 0;
    }
    
    return (card_values[a.charAt(0)] > card_values[b.charAt(0)] ? -1 : 1);
};
    
var get_value = function(cards){
    
    // console.log('->',cards);
    
    var cards_count = cards.length;
    cards.sort( card_cmp );
    // console.log('<-',cards);
    
    var straight = true,
        old_value = false,
        colors = {
            'H': 0,
            'C': 0,
            'S': 0,
            'D': 0
        },
        values = {},
        i;
  
    for(i = 0 ; i < cards_count ; i++){
        var value = cards[i].charAt(0);
        var color = cards[i].charAt(1);
        
        var card_value = card_values[value];
        if( old_value ){
            straight &= ((old_value - card_value)==1);
        }
        old_value = card_value;
    
        if( 'undefined' == typeof(values[card_value]) ){
            values[card_value] = 0;
        }
        values[card_value]++;
        colors[color]++;
    }
    
    
    var flush = false;
    for(i in colors){
        if( colors[i] == 5 ){
            flush = true;
            break;
        }
    }
    
    values = values_sort(values);
    
    var kicker = 0;
    var combo = 'high_card';
    
    var highest_card = cards[0].charAt(0);
    if( flush ){
        if( straight ){
            if( highest_card == 'A' ){
                // royal flush !!!
                combo = 'royal_flush';
                // no kicker (all royal flush are eqaully strong)
            }
            else{
                // straight flush !
                combo = 'straight_flush';
                // kicker: highest card of the straight (first one)
                kicker = card_values[highest_card];
            }
        }
        else{
            // flush!
            combo = 'flush';
            
            // kicker : highest cards
            for(i=0, cnt = values.length ; i < cnt ; i++){
                var k = parseInt(values[i].key);
                kicker += Math.pow(2, k);
            }
        }
    }
    else if( straight ){
        // straight!
        combo = 'straight';
        // kicker: highest card of the straight (first one)
        kicker = card_values[ highest_card ];
    }
    else{
        // four_of_a_kind
        if( values[0].value == 4 ){
            combo = 'four_of_a_kind';
        }
        else if( values[0].value == 3 && values[1].value == 2 ){
            combo = 'full_house';
        }
        else if( values[0].value == 3 ){
            combo = 'three_of_a_kind';
        }
        else if( values[0].value == 2 && values[1].value == 2 ){
            combo = 'two_pairs';
        }
        else if( values[0].value == 2 ){
            combo = 'one_pair';
        }
        else{
            combo = 'high_card';
        }
        
        // kicker
        for(i=0, cnt = values.length ; i < cnt ; i++){
            var k = parseInt(values[i].key);
            kicker += k * Math.pow(10, (cnt - i - 1) * 2);
        }
        
    }
   
    var score = combos[combo];
    // console.log(score, kicker);
    
    var kicker_len = (''+kicker).length;
    kicker = new Array( 10 - kicker_len + 1).join('0') + kicker;
    
    return (score+kicker);
};


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' ');
        var val_left = get_value( tmp.slice(0, 5) );
        var val_right = get_value( tmp.slice(5,10) );
        
        var cmp = val_left.localeCompare(val_right);
        
        if( cmp < 0) console.log('right');
        else if( cmp > 0 ) console.log('left');
        else console.log('none');
    }
});
