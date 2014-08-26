// https://www.codeeval.com/open_challenges/65/

var cols = 4;
var rows = 3;
var grid = ['A','B','C','E','S','F','C','S','A','D','E','E'];
var neighbours = {};
var grid_max = cols * rows;
for( var i = 0 ; i < grid_max ; i++ ){
    if( 'undefined' === typeof(neighbours[i]) ){
        neighbours[i] = [];
    }
                    
    var col = i % cols;
    var row = Math.floor(i / cols);
    
    // left
    if( col > 0 ){
        neighbours[i].push( i - 1 );
    }
    // right
    if( col < cols-1 ){
        neighbours[i].push( i + 1 );
    }
    // top
    if( row > 0 ){
        neighbours[i].push( i - cols );
    }
    // bottom
    if( row < rows-1 ){
        neighbours[i].push( i + cols );
    }
}


var browse_grid = function (letters, depth , grid_idx , used ){
    var found = false;
    if( depth < letters.length ){
        var letter = letters[depth];
        if( grid_idx === false ){
            // I try to find one or more starting points
            for( var i = 0 ; i < grid_max ; i++ ){
                if( grid[ i ] === letter ){
                    var used = {};
                    used[i] = true;
                    found = found || browse_grid(letters, depth+1, i, used );
                }
            }
        }
        else{
            var neighbours_idx = neighbours[grid_idx];
            var neighbours_cnt = neighbours_idx.length;
            for( var i = 0 ; i < neighbours_cnt ; i++){
                var neighbour = neighbours_idx[i];
                if( (grid[neighbour] === letter) && ('undefined' === typeof(used[neighbour])) ){
                    var next_used = {};
                    for(var j in used){
                        next_used[j] = true;
                    }
                    next_used[neighbour] = true;
                    found = found || browse_grid(letters, depth+1, neighbour, next_used);
                }
            }
        }
    }
    else{
        found = true;
    }
    return found;
};
                

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var letters = [];
        var len = line.length;
        for(var i=0 ; i < len ; i++){
            letters[i] = line.charAt(i);
        }
        console.log ( browse_grid(letters,0,false,{}) ? 'True' : 'False' );
    }
});