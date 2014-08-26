// https://www.codeeval.com/open_challenges/109/


// http://wiki.openstreetmap.org/wiki/Mercator

var MATH_PI = Math.PI;
var MATH_PI_4 = MATH_PI/4;
var MATH_PI_180 = MATH_PI/180;
var MATH_PI_180_INV = 180/MATH_PI;

function lon2x( lon ) { return lon * MATH_PI_180 * 6378137; }
function lat2y( lat ) { return MATH_PI_180_INV * Math.log(Math.tan(MATH_PI_4+lat*MATH_PI_180*0.5)); }

// http://www.java-gaming.org/index.php?topic=22590.0
function lines_intersect(x1, y1, x2, y2, x3, y3, x4, y4){
    // Return false if either of the lines have zero length
    if (x1 == x2 && y1 == y2 ||
        x3 == x4 && y3 == y4){
        return false;
    }
    // Fastest method, based on Franklin Antonio's "Faster Line Segment Intersection" topic "in Graphics Gems III" book (http://www.graphicsgems.org/)
    var ax = x2-x1;
    var ay = y2-y1;
    var bx = x3-x4;
    var by = y3-y4;
    var cx = x1-x3;
    var cy = y1-y3;

    var alphaNumerator = by*cx - bx*cy;
    var commonDenominator = ay*bx - ax*by;
    if (commonDenominator > 0){
        if (alphaNumerator < 0 || alphaNumerator > commonDenominator){
            return false;
        }
    }else if (commonDenominator < 0){
        if (alphaNumerator > 0 || alphaNumerator < commonDenominator){
            return false;
        }
    }
    var betaNumerator = ax*cy - ay*cx;
    if (commonDenominator > 0){
        if (betaNumerator < 0 || betaNumerator > commonDenominator){
            return false;
        }
    }else if (commonDenominator < 0){
        if (betaNumerator > 0 || betaNumerator < commonDenominator){
            return false;
        }
    }
    if (commonDenominator == 0){
        // This code wasn't in Franklin Antonio's method. It was added by Keith Woodward.
        // The lines are parallel.
        // Check if they're collinear.
        var y3LessY1 = y3-y1;
        var collinearityTestForP3 = x1*(y2-y3) + x2*(y3LessY1) + x3*(y1-y2);   // see http://mathworld.wolfram.com/Collinear.html
        // If p3 is collinear with p1 and p2 then p4 will also be collinear, since p1-p2 is parallel with p3-p4
        if (collinearityTestForP3 == 0){
            // The lines are collinear. Now check if they overlap.
            if (x1 >= x3 && x1 <= x4 || x1 <= x3 && x1 >= x4 ||
                x2 >= x3 && x2 <= x4 || x2 <= x3 && x2 >= x4 ||
                x3 >= x1 && x3 <= x2 || x3 <= x1 && x3 >= x2){
            if (y1 >= y3 && y1 <= y4 || y1 <= y3 && y1 >= y4 ||
                y2 >= y3 && y2 <= y4 || y2 <= y3 && y2 >= y4 ||
                y3 >= y1 && y3 <= y2 || y3 <= y1 && y3 >= y2){
                    return true;
                }
            }
        }
        return false;
    }
    return true;
}

var build_bridges = function(points){
    var bridges = [];
    for(var i=0, len = points.length; i < len; i++){
        var ps = points[i];
        ps = ps.replace(/[^0-9\.\-]/g,' ').trim();
        var tmp = ps.split(/\s+/);
        bridges.push({
            'id': Number(tmp[0]),
            'lat_a': Number(tmp[1]),
            'lng_a': Number(tmp[2]),
            'lat_b': Number(tmp[3]),
            'lng_b': Number(tmp[4])
        });
    }
    
    bridges.sort(function(a,b){
        return a.id - b.id;
    });
    
    
    // check xing between each bridges
    var bridges_cnt = bridges.length;
    var xings = {};
    for( var i=0 ; i < bridges_cnt ; i++){
        for( var j = i+1 ; j < bridges_cnt ; j++){
            
            // mercator projection
            var xai = lon2x( bridges[ i ]['lng_a'] );
            var yai = lat2y( bridges[ i ]['lat_a'] );
            var xbi = lon2x( bridges[ i ]['lng_b'] );
            var ybi = lat2y( bridges[ i ]['lat_b'] );
            
            var xaj = lon2x( bridges[ j ]['lng_a'] );
            var yaj = lat2y( bridges[ j ]['lat_a'] );
            var xbj = lon2x( bridges[ j ]['lng_b'] );
            var ybj = lat2y( bridges[ j ]['lat_b'] );
            
            if( lines_intersect(xai, yai, xbi, ybi, xaj, yaj, xbj, ybj) ){
                if( 'undefined' === typeof(xings[i]) ) xings[i] = {};
                if( 'undefined' === typeof(xings[j]) ) xings[j] = {};
                
                xings[i][j] = true;
                xings[j][i] = true;
            }
        }
    }
    
    // console.log(xings);
    
    // now, I know who blocks who
    // I will gradually decide not to build some bridges, and see if it can increase the total built
    
    var max = parseInt( new Array(bridges_cnt + 1).join('1') , 2); // bindec
    var i = max + 1 ;
    
    var best = false;
    var current_max = 0;
    while( i-- ){
        // var combo = str_pad( decbin($i), $bridges_cnt, '0', STR_PAD_LEFT );
        
        var combo = i.toString(2); // decbin
        
        var combo_length = combo.length;
        var count_one = 0;
        var j = combo_length;
        while(j--){
            if( combo.charAt(j) == '1' ){
                count_one++;
            }
        }
        if( count_one <= current_max ){
            // number of 1 < current_max, no need to go 
            continue;
        }
        
        // prefix
        var k = bridges_cnt - combo_length;
        var prefix = '';
        while(k--){
            prefix += '0';
        }
        combo = prefix + combo;
        
        var build = 0;
        // clone
        var xs = {};
        for( var a in xings ){
            xs[a] = {};
            for( var b in xings[a] ){
                xs[a][b] = true;
            }
        }
        
        // console.log(xs, xings);
        j = bridges_cnt;
        while( j-- ){
            if( combo.charAt(j) == '0' ){
                // I won't build this bridge
                // Is the total of built bridges better now?
                
                if( 'undefined' !== typeof( xs[j] ) ){
                    // console.log('!undefined', xs[j]);
                    
                    for(var k in xs[j] ){
                        // console.log('-->',k, xs);
                        delete xs[k][j];
                        // console.log('reste',xs[k]);
                        if( !xs[k] || (Object.keys(xs[k]).length === 0)  ) {
                            delete xs[k];
                        }
                        // console.log('<--',xs);
                    }
                    // console.log('->',xs);
                    delete xs[j];
                    // console.log('<-',xs);
                }
            }
            else{
                build++;
            }
        }
        
        // console.log(build, current_max);
        
        if( build < current_max ){
            // I'm done, I won't find a better combo
            continue;
        }
        
        var max_to_build = build - Object.keys(xs).length;
        
        if( max_to_build > current_max ){
            best = combo;
            current_max = max_to_build;
        }
        
    }
    
    // console.log(combos);
    if( best ){
        for( var i=0 ; i < bridges_cnt ; i++){
            if( best.charAt(i) == '1' ){
                console.log(bridges[i].id);
            }
        }
    }
    
};

var points = [];
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        points.push( line );
    }
});
build_bridges(points);