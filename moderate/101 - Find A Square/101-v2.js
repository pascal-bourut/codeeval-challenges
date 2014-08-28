// https://www.codeeval.com/open_challenges/101/
var fs = require("fs");

fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        
        var coords = line.split(/[\(\), ]+/);
        var points = [];
        var distances = [];
        var distance = 0;
        var ok = true;
        
        for( var i=1 ; i <= 8 ; i += 2 ){
            var x = Number(coords[i]);
            var y = Number(coords[i+1]);
            var point = [x, y];
            points.push(point);
            if( i > 2 ){
                distance = (points[0][0] - x) * (points[0][0] - x) + (points[0][1] - y) * (points[0][1] - y);
                if( distance === 0 ){
                    ok = false;
                    break;
                }
                distances.push( {k:'0-' + ((i-1)/2), v: distance } );
            }
            if( i > 6 ){
                distance = (points[2][0] - points[1][0]) * (points[2][0] - points[1][0]) + (points[2][1] - points[1][1]) * (points[2][1] - points[1][1]);
                if( distance === 0 ){
                    ok = false;
                    break;
                }
                distances.push( {k:'1-2', v: distance } );
            }
        }
        if( ok ){
            distances.sort(function(a,b){return a.v - b.v});
            ok = (distances[0].v !== 0) && 
                 (distances[0].v == distances[1].v) && 
                 ( (distances[0].v * 2).toFixed(5) == (distances[3].v).toFixed(5) );
        }
        console.log( ok ? 'true' : 'false' );
    }
});