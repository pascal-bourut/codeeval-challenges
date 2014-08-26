// https://www.codeeval.com/open_challenges/128/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
       
        var result = [];
        var prev = false;
        var count = 0;
        var numbers = line.split(' ');
        for( var i=0, cnt=numbers.length ; i < cnt ; i++){
           var current = numbers[i];
            if( current === prev ){
                count++;
            }
            else{
                if( prev !== false ){
                    result.push(count);
                    result.push(prev);
                    count = 0;
                }
                count++;
            }
            prev = current;
        }
        if( count ){
            result.push(count);
            result.push(prev);
        }
        console.log(result.join(' '));
    }
});