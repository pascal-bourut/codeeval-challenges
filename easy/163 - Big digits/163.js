// https://www.codeeval.com/open_challenges/163/


var tmp = "-**----*--***--***---*---****--**--****--**---**--\n*--*--**-----*----*-*--*-*----*-------*-*--*-*--*-\n*--*---*---**---**--****-***--***----*---**---***-\n*--*---*--*-------*----*----*-*--*--*---*--*----*-\n-**---***-****-***-----*-***---**---*----**---**--\n--------------------------------------------------";

var i, j;
var tmp = tmp.split("\n");
var big_digits = [];
for(i = 0 ; i < 6 ; i++ ){
    var line = tmp[i].trim();
    for(j = 0 ; j <= 9 ; j++ ){
        if( 'undefined' === typeof(big_digits[j]) ){
            big_digits[j] = [];
        }
        big_digits[j].push( line.substr(j * 5, 5) );
    }
}

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var digits = line.replace(/[^0-9]+/g,'');
        var result = '';
        var len = digits.length;
        for(i = 0 ; i < 6 ; i++ ){
            for( j = 0;  j < len ; j++ ){
                result += big_digits[digits[j]][i];
            }
            result += "\n";
        }
        console.log(result.trim());
    }
});
