// https://www.codeeval.com/open_challenges/101/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        
        var coords = line.split(/[\(\), ]+/);
        // bounding box of the 4 points
        var bbox_min_x = 11;
        var bbox_max_x = -1;
        var bbox_min_y = 11;
        var bbox_max_y = -1;
        var points = {};
        for( var i=1 ; i <= 8 ; i += 2 ){
            var x = Number(coords[i]);
            var y = Number(coords[i+1]);
            if( x < bbox_min_x ) bbox_min_x = x;
            if( x > bbox_max_x ) bbox_max_x = x;
            if( y < bbox_min_y ) bbox_min_y = y;
            if( y > bbox_max_y ) bbox_max_y = y;
            points[x+','+y] = [x, y];
        }
        
        var count = Object.keys(points).length;
                
        if( count == 4 ){
            // first condition: bbox width = bbox height
            var w = bbox_max_x - bbox_min_x;
            var h = bbox_max_y - bbox_min_y;
                            
            if( w>0 && h>0 && w == h ){
                // then, all 4 points must be on the bbox border
                var all_one = true;
                var all_two = true;
                for( var i in points ){
                    var x = points[i][0];
                    var y = points[i][1];
                    var on_bbox = ( ( x == bbox_min_x || x == bbox_max_x ) ? 1 : 0) + ( ( y == bbox_min_y || y == bbox_max_y ) ? 1 : 0 );
                    if( on_bbox === 0 ){
                        all_two = false;
                        all_one = false;
                        break;
                    }
                    else if( on_bbox == 1 ){
                        all_two = false;
                    }
                    else if( on_bbox == 2 ){
                        all_one = false;
                    }
                }
                // all 4 points must have 1 or 2 coordinates on the border
                // but not a mix
                ok = ( all_one || all_two ) && !(all_one && all_two);
            }
            else{
                ok = false;
            }
        }
        else if( count == 1 ){
            // 1 point != 1 square
            ok = false;
        }
        else{
            // 2 or 3 distinct points
            ok = false;
        }
                        
        console.log( ok ? 'true' : 'false' );
    }
});