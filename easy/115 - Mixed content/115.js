// https://www.codeeval.com/open_challenges/115/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var all = line.split(',');
        var words = [];
        var digits = [];
                        
        for( var i=0, cnt=all.length ; i < cnt ; i++ ){
            var a = all[i];
            if( isNaN(Number(a)) ){
                words.push(a);
            }
            else{
                digits.push(a);
            }
        }
        words = words.join(',');
        digits = digits.join(',');
        console.log( words+(words&&digits?'|':'')+digits );
    }
});