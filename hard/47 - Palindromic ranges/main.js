// https://www.codeeval.com/open_challenges/47/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' ');
        var L = Number(tmp[0]);
        var R = Number(tmp[1]);
        var i = 0, j = 0;
        var palindromes = {};
        // how many palindrome between L and R?
        for( i = L ; i <= R ; i++ ){
            var str = ''+i;
            if( str == str.split('').reverse().join('') ){
                palindromes[ i ] = true;
            }
        }
                        
        var intervals = 0;
        for( i = L ; i <= R ; i++ ){
            var cpt = 0;
            for( j = i ; j <= R ; j++ ){
                if( 'undefined' !== typeof(palindromes[j]) ){
                    cpt++;
                }
                if( (cpt%2) == 0 ){
                    intervals++;
                }
            }
        }
        console.log(intervals);
    }
});