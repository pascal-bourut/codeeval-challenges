// https://www.codeeval.com/open_challenges/133/

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var streets = tmp[0].substr(1, tmp[0].length - 2).split(',');
        var avenues = tmp[1].substr(1, tmp[1].length - 2).split(',');
        
        var smax = streets.length - 1;
        var amax = avenues.length - 1;
        
        var tan = avenues[amax] / streets[smax];
        var crossed = 0;
                        
        for( var s=0 ; s < smax ; s++ ){
            for( var a=0 ; a < amax ; a++ ){
                var curr_x = streets[s];
                var curr_y = avenues[a];
                
                var next_x = streets[s+1];
                var next_y = avenues[a+1];
                
                if ( (next_x > (curr_y / tan)) && (next_y > (tan * curr_x)) ){
                    crossed++;
                }
            }
        }
        console.log(crossed);
    }
});
