// https://www.codeeval.com/open_challenges/56/

var target_position = 15,
    cols = 4,
    rows = 4,
    neighbours = {},
    grid_max = cols * rows,
    i;

i = grid_max;
while( i-- ){
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

var browse_grid = function(current_position, browsed ){
    var count = 0;
    
    var current_position_neighbours = neighbours[ current_position ];
    var cnt = current_position_neighbours.length;
    var i = cnt;
    while( i-- ){
        var neighbour = current_position_neighbours[ i ];
        
        if( neighbour == target_position ){
            count += 1;
        }
        else if( 'undefined' === typeof(browsed[neighbour]) ){
            var next_browsed = {};
            for(var j in browsed){
                next_browsed[j] = true;
            }
            next_browsed[neighbour] = true;
            
            count += browse_grid(neighbour, next_browsed);
        }
    }
    return count;
};

console.log( browse_grid(0, {0:true} ) );
