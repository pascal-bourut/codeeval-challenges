// https://www.codeeval.com/open_challenges/110/

var small_numbers = {
    'zero': 0,
    'one': 1,
    'two': 2,
    'three': 3,
    'four': 4,
    'five': 5,
    'six': 6,
    'seven': 7,
    'eight': 8,
    'nine': 9,
    'ten': 10,
    'eleven': 11, 
    'twelve': 12, 
    'thirteen': 13, 
    'fourteen': 14, 
    'fifteen': 15, 
    'sixteen': 16, 
    'seventeen': 17, 
    'eighteen': 18, 
    'nineteen': 19,
    'twenty': 20,
    'thirty': 30,
    'forty': 40,
    'fifty': 50,
    'sixty': 60,
    'seventy': 70,
    'eighty': 80,
    'ninety': 90
};

var large_numbers = {
    'hundred': 2,
    'thousand': 3,
    'million': 6
};

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var words = line.split(' ');
        var max = words.length;
        var i = max;
        var result = 0;
        var pow = 0;
        while( i-- ){
            if( 'undefined' !== typeof(small_numbers[words[i]]) ){
                result += small_numbers[words[i]] * Math.pow(10, pow);
            }
            else if( 'undefined' !== typeof(large_numbers[words[i]]) ){
                if( large_numbers[words[i]] > pow ){
                    pow = large_numbers[words[i]];
                }
                else{
                    pow += large_numbers[words[i]];
                }
            }
            else if( 'negative' == words[i] ){
                result = -result;
            }
        }
        console.log(result);
    }
});