// https://www.codeeval.com/open_challenges/7/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var operators = [];
        var digits = [];
                        
        var tokens = line.split(' ');
        for( var i=0, cnt = tokens.length;  i < cnt ; i++){
            var token = tokens[ i ];
            if( token == '+' || token == '*' || token == '/' ){
                operators.push( token );
            }
            else{
                digits.push( Number(token) );
            }
        }
        
        var cnt = operators.length;
        var i = cnt;
        var j = 0;
        var result = digits[0];
        while( i-- ){
            j++;
            switch( operators[ i ] ){
                case '+':
                    result += digits[ j ];
                    break;
                case '*':
                    result *= digits[ j ];
                    break;
                case '/':
                    result /= digits[ j ];
                    break;
            }//
        }//
        console.log( result );
    }
});