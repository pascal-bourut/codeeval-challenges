// https://www.codeeval.com/open_challenges/17/

// Kadane's algorithm

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(',');
        var first = Number(tmp[0]);
        var current_sum = first,
            best_sum = first;
        
        for( var i=1, cnt=tmp.length; i < cnt ; i++){
            var x = Number(tmp[i]);
            if( current_sum + x > x ){
                // if x increases sum, add x
                current_sum += x;
            }
            else{
                // if not, take x as sum
                current_sum = x;
            }
            if( current_sum > best_sum ){
                best_sum = current_sum;
            }
        }
        console.log(best_sum);
    }
});
