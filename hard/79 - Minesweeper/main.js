var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var tokens;
        if( tokens = line.match(/^([0-9]+),([0-9]+);([\.\*]+)$/) ){
            var n = tokens[1];
            var m = tokens[2];
            var str = tokens[3];
            var mines = [];
            var len = str.length;
            var i = len;
            while(i--){
                mines[i] = str.charAt(i);
            }
            
            var grid = [];
            var max = m * n;
            for(i = 0 ; i < max ; i++){
                X = i % m;
                Y = Math.floor(i / m);
                                    
                if( mines[i] == '*' ){
                    // on a mine
                    grid[i] = '*';
                }
                else{
                    var cpt = 0;
                    // empty square
                    // how many mine around me?
                    for(var y=-1; y <= 1; y++){
                        for( var x=-1; x <= 1; x++){
                            if( (x!=0)||(y!=0) ){
                                var test_x = X + x;
                                var test_y = Y + y;
                                if( (test_x >= 0 && test_x < m) && (test_y >= 0 && test_y < n) ){
                                    var test_i = test_x + test_y * m;
                                    if( mines[test_i] == '*' ){
                                        cpt++;
                                    }
                                }
                            }
                        }
                    }
                    grid[i] = cpt;
                }
            }
            console.log( grid.join('') );
        }
    }
});
