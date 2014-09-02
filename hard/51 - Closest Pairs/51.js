// https://www.codeeval.com/open_challenges/51/

var distance_squared_max = 10000 * 10000 + 1;
var points = [];
                
function point_cmp(a, b){
    // sort x
    return a[0] - b[0];
}

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        if( line.indexOf(' ') === -1) {
            var cnt = points.length;
            if( cnt > 0 ){
                var distance_squared = distance_squared_max;
                
                points.sort(point_cmp);
                
                for(var i=0, max=cnt-1 ; i < max ; i++){
                    for(var j = i+1; j < cnt ; j++){
                        var p0 = points[i];
                        var x0 = p0[0];
                        var p1 = points[j];
                        var x1 = p1[0];
                        
                        var xd = x1 - x0;
                        if( (xd * xd) > distance_squared ){
                            // echo '.';
                            break;
                        }
                        
                        var yd = p1[1] - p0[1];
                        var ds = xd * xd + yd * yd;
                        if( ds < distance_squared ){
                            distance_squared = ds;
                        }
                    }
                }
                console.log( ( distance_squared >= distance_squared_max ) ? 'INFINITY' : (Math.round(Math.sqrt(distance_squared) * 10000) / 10000).toFixed(4) );
            }
            points = [];
        }
        else{
            points.push(line.split(' '));
        }
    }
});
