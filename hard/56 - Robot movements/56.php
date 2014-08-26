<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/56/
             
$cols = 4;
$rows = 4;
$neighbours = array();
$grid_max = $cols * $rows;
for( $i = 0 ; $i < $grid_max ; $i++ ){
    if( !isset($neighbours[$i]) ){
        $neighbours[$i] = array();
    }
    
    $col = $i % $cols;
    $row = floor($i / $cols);
    
    // left
    if( $col > 0 ){
        $neighbours[$i][] = $i-1;
    }
    // right
    if( $col < $cols-1 ){
        $neighbours[$i][] = $i+1;
    }
    // top
    if( $row > 0 ){
        $neighbours[$i][] = $i - $cols;
    }
    // bottom
    if( $row < $rows-1 ){
        $neighbours[$i][] = $i + $cols;
    }
}

function browse_grid($current_position, $target_position, $browsed = array() ){
    global $neighbours;
    
    $count = 0;
    
    $current_position_neighbours = $neighbours[$current_position];
    $cnt = count($current_position_neighbours);
    $i = $cnt;
    while($i--){
        $neighbour = $current_position_neighbours[$i];
        
        if( $neighbour == $target_position ){
            $count += 1;
        }
        else if( !isset($browsed[$neighbour]) ){
            $next_browsed = $browsed;
            $next_browsed[$neighbour] = true;
            $count += browse_grid($neighbour, $target_position, $next_browsed);
        }
    }
    return $count;
}

echo browse_grid(0, 15, array( 0 => true ))."\n";
?>