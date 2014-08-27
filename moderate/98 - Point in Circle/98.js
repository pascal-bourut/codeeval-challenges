// https://www.codeeval.com/open_challenges/98/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var matches = null;
        if( null !== ( matches = line.match(/^Center: \(([0-9\-\.]+), ([0-9\-\.]+)\); Radius: ([0-9\-\.]+); Point: \(([0-9\-\.]+), ([0-9\-\.]+)\)$/) ) ){
            var center_x = Number(matches[1]);
            var center_y = Number(matches[2]);
            var radius = Number(matches[3]);
            var point_x = Number(matches[4]);
            var point_y = Number(matches[5]);
                            
            var square_distance = ( center_x - point_x ) * ( center_x - point_x ) + ( center_y - point_y ) * ( center_y - point_y );
            console.log( (square_distance <= radius * radius) ? 'true' : 'false' );
        }
    }
});