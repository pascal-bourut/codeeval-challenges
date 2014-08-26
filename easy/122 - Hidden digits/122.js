// https://www.codeeval.com/open_challenges/122/


var trans = {
    'a': 0,
    'b': 1,
    'c': 2,
    'd': 3,
    'e': 4,
    'f': 5,
    'g': 6,
    'h': 7,
    'i': 8,
    'j': 9
};


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var result = '';
        for( var i=0, cnt=line.length ; i < cnt ; i++){
            var c = line.charAt(i);
            if( 'undefined' != typeof(trans[c]) ){
                result += trans[c];
            }
            else if( c >= 0 && c <= 9 ){
                result += c;
            }
        }
        console.log(result !== '' ? result : 'NONE' );
    }
});