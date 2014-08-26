// https://www.codeeval.com/open_challenges/82/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        // An Armstrong number is an n-digit number that is equal to the sum of the n'th powers of its digits. Determine if the input numbers are Armstrong numbers.
        var n = line.length;
        var sum = 0;
        for(var i=0;i<n;i++){
            sum += Math.pow( Number(line.charAt(i)), n);
        }
        console.log( sum == line ? 'True' : 'False' );
    }
});