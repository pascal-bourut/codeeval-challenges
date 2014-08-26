// https://www.codeeval.com/open_challenges/158/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' | ');
        var numbers = tmp[0].split(' ');
        var iterations = Number(tmp[1]);
        var count = numbers.length;
        
        // Worst case performance O(n^2)
        if( iterations >= count * count ){
            iterations = count * count;
        }
        
                        
        for(var j=0; j < iterations ; j++){
            var max_invert = count - 1 - j;
            var i = -1;
            while(++i < max_invert){
                var a = Number(numbers[i]);
                var b = Number(numbers[i+1]);
                if(a > b){
                    numbers[i+1] = a;
                    numbers[i] = b;
                }
            }
        }//
        console.log(numbers.join(' '));
    }
});