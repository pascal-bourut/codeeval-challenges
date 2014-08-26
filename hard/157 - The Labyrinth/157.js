// https://www.codeeval.com/open_challenges/157/

var cols = 0;
var rows = 0;
var labyrinth = '';

var bfs = function(graph, start, end){
    var distance = {};
    for( var k in graph){
        distance[ k ] = -1;
    }
    distance[ start ] = 0;
    
    var previous = {};
    previous[start] = 0;
    
    var q = [];
    q.push(start);
    
    while ( q.length ){
        var v = q.shift();
        for( var u in graph[v] ){
            var u = graph[v][u];
            if ( u == end ) {
                previous[end] = v;
                return previous;
            }
            if ( 'undefined' === typeof(previous[u]) ){
                distance[ u ] = distance[ v ] + 1;
                q.push( u );
                previous[u] = v;
            }
        }
    }
    return false;
};

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
    
        if( cols === 0 ){
            cols = line.length;
        }
        labyrinth += line;
        rows++;
    }
});

var entrance = labyrinth.indexOf(' ');
var exit = labyrinth.lastIndexOf(' ');
                
var graph = {};
var len = labyrinth.length;
var i = len;
while(i--){
    var l = labyrinth[i];
    if( l === ' ' ){
        var x = i % cols;
        var y = Math.floor(i/cols);
        var test = [];
        // left
        if( x > 0 ){
            test.push( i - 1 );
        }
        // right
        if( x < (cols-1) ){
            test.push( i + 1 );
        }
        // top
        if( y > 0 ){
            test.push( i - cols );
        }
        // bottom
        if( y < (rows-1) ){
            test.push( i + cols );
        }

        for(var j=0, cnt=test.length; j < cnt ; j++){
            var t = test[j];
            if( labyrinth[t] === ' ' ){
                if( 'undefined' === typeof(graph[i]) ){
                    graph[i] = [];
                }
                graph[i].push(t);
            }
        }
    }
}

var result = bfs(graph, entrance, exit); 
if( result ){
    var end = exit;
    labyrinth = labyrinth.split('');
    labyrinth[end] = '+';
    do{
        end = result[end];
        labyrinth[end] = '+';
    }
    while( end != entrance );
}

labyrinth = labyrinth.join('');
for( var i=0 ; i < rows  ; i++ ){
    console.log( labyrinth.substr(i * cols , cols) );
}