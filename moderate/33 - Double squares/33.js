// https://www.codeeval.com/open_challenges/33/
var first = true;
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        if( first ) {
            // You should first read an integer N, the number of test cases. 
            first = false;
        }
        else{
            // console.log('-------------------- ' + line);
            var number = Number(line);
            var i = (Math.sqrt(number)>>0) + 1;
            var total = 0;
            while( i-- ){
                var sqrt = Math.sqrt( number - i*i );
                if( sqrt == (sqrt >> 0) ){
                    total++;
                }
            }
            console.log( (total / 2)>>0 );
        }
    }
});