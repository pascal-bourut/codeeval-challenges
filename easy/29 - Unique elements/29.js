// https://www.codeeval.com/open_challenges/29/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var numbers = line.split(',');
        var cnt = numbers.length;
        var i = cnt;
        var unique = [];
        while(i--){
            if( -1 == unique.indexOf(numbers[i]) ){
                unique.push(numbers[i]);
            }
            
        }
        unique.sort(function(a,b){return a-b;});
        console.log(unique.join(','));
    }
});