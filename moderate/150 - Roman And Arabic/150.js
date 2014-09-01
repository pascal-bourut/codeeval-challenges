// https://www.codeeval.com/open_challenges/150/
var romans = {
    'I': 1,
    'V': 5,
    'X': 10,
    'L': 50,
    'C': 100,
    'D': 500,
    'M': 1000
};

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var chars = line.split('');
        var old_r = 0;
        var i = chars.length;   
        var total = 0;
        while( (i-=2) >= 0 ){
            var a = chars[i];
            var r = romans[chars[i+1]];

            if( old_r > r ){
                total -= a * r;
            }
            else{
                total += a * r;
            }
            old_r = r;
        }
        console.log(total);
    }
});