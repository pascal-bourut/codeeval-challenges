// https://www.codeeval.com/open_challenges/72/

var neighbours = null,
    target = 0,
    grid = null,
    min = 0;

var make_neighbours = function(n, cells){
    var grid_max = n * n,
        i,
        neighbours = [];
        
    i = grid_max;
    while( i-- ){
        neighbours[i] = {};
        // right
        if( i%n < n-1 ){
            neighbours[i]['r'] = i + 1;
        }
        // bottom
        if( i < grid_max-n ){
            neighbours[i]['b'] = i + n;
        }
    }
    return neighbours;
};

var scan_grid = function(idx, sum){
    
    // console.log(sum,' + ',grid[idx]);
    sum += parseInt(grid[idx]);
    
    if( sum >= min ) return;
    
    if( idx == target ){
        min = sum;
        // console.log('END '+sum); 
    }
    else{
        if( 'undefined' !== typeof(neighbours[idx]['r']) ){
            scan_grid(neighbours[idx]['r'], sum);
        }
        if( 'undefined' !== typeof(neighbours[idx]['b']) ){
            scan_grid(neighbours[idx]['b'], sum);
        }
        
    }
    return;
};

var browse_grid = function(n, cells){
    grid = cells;
    min = Infinity;
    target = n * n - 1;
    neighbours = make_neighbours(n, cells);
    
    // console.log(grid, min, target);
    scan_grid(0,0);
    // console.log(min);
    
    return min;
};

var lines = new Array();
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        lines.push( line );
    }
});

var nb = lines.length;
// console.log(lines);
// console.log(nb);

for(var i=0 ; i < nb ; ){
    var n = parseInt(lines[ i ]);
    var rows = '';
    for( j=1 ; j <= n ; j++){
        var row = lines[i+j];
        if(j>1) rows += ',';
        rows += row;
    }
    var cells = rows.split(',');
    console.log( browse_grid(n, cells) );
    i += (n+1);
}
