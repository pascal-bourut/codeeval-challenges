// https://www.codeeval.com/open_challenges/161/


function game_of_life(grid, size){
    var max = size * size;
    // count live neighbors of every cell
    var neighbors = [];
    var i = 0;
    for( i=0; i < max ; i++ ){
        neighbors[i] = 0;
    }
    for( i=0; i < max ; i++ ){
        var c = i % size;
        var r = (i / size) >> 0;
        if( grid[i] == '*' ){
            // alive
            
            if( c > 0 ){
                neighbors[i - 1]++; // update left neighbor
                if( r > 0 ){
                    neighbors[i - size - 1]++; // update top-left neighbor
                }
                if( r < size-1 ){
                    neighbors[i + size - 1]++; // update bottom-left neighbor
                }
            }
            if( c < size-1 ) {
                neighbors[i + 1]++; // update right neighbor
                if( r > 0 ){
                    neighbors[i - size + 1]++; // update top-right neighbor
                }
                if( r < size-1 ){
                    neighbors[i + size + 1]++; // update bottom-right neighbor
                }
            }
            if( r > 0 ){
                neighbors[i - size]++; // update top neighbor
            }
            if( r < size-1 ){
                neighbors[i + size]++; // update bottom neighbor
            }
        }
    }
    
    for( i=0 ; i < max ; i++ ){
        var alive = (grid[i] == '*');
        var cnt = neighbors[i];
        if( alive ){
            // alive
            if( cnt < 2 || cnt > 3 ){
                // Any live cell with fewer than two live neighbors dies, as if caused by under-population.
                // Any live cell with more than three live neighbors dies, as if by overcrowding.
                grid[i] = '.';
            }
        }
        else{
            // dead
            // Any dead cell with exactly three live neighbors becomes a live cell, as if by reproduction.
            if( cnt == 3 ){
                grid[i] = '*';
            }
        }
    }
    
    return grid;
}

var grid = '';
var size = 0;

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        if( !size ) size = line.length;
        grid += line;
    }
});

grid = grid.split('');
var i = 10;
while( i-- ){
    grid = game_of_life(grid, size);
}

for( i=0; i < size; i++){
    console.log( grid.slice(i*size, (i+1)*size).join('') );
}