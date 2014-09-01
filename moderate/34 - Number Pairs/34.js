// https://www.codeeval.com/open_challenges/34/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(';');
        var numbers = tmp[0].split(',');
        var sum = Number(tmp[1]);
        var half_sum = sum / 2;
        var cnt = numbers.length;
        var i = cnt;
        while( i--){
            numbers[i] = Number(numbers[i]);
        }
        
        var lower_value = numbers[0];
        var pairs = [];
        // console.log(line);
        i = cnt;
        while( i-- > 1 ){
            var ni = numbers[i];
            
            // console.log('ni',ni);
            if( half_sum > ni ){
                // console.log('no more pairs possibles 1');
                break;
            }
            
            var target = sum - ni;
            if( ni >= sum && lower_value > target ){
                // console.log('no more pairs possibles 2');
                continue;
            }
            // console.log('target',target);
            var j = i;
            while( j-- ){
                var nj = numbers[j];
                // console.log('nj',nj);
                if( nj == target ){
                    // console.log(ni,nj);
                    pairs.push(nj+','+ni);
                }
                else if( nj < target ){
                    // console.log('nj too small => next i');
                    break;
                }
            }
        }
        if( pairs.length ){
            console.log(pairs.join(';'));
        }
        else{
            console.log('NULL');
        }
        
    }
});