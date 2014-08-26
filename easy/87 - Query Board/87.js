// https://www.codeeval.com/open_challenges/87/

var board = [];
var cols = 256;
var rows = 256;

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var query = line.split(' ');
        switch(query[0]){
            case 'SetCol':
                for(var i=0; i<rows; i++){
                    board[ Number(query[1]) + i * cols] = Number(query[2]);
                }
                break;
            case 'SetRow': 
                 for(var i=0; i<cols; i++){
                     board[ Number(query[1]) * rows + i] = Number(query[2]);
                 }
                break;
            case 'QueryCol':
                var sum = 0;
                for(var i=0; i<rows; i++){
                    sum += ( 'undefined' === typeof(board[ Number(query[1]) + i * cols]) ) ? 0 : board[ Number(query[1]) + i * cols];
                }
                console.log(sum);
                break;
            case 'QueryRow': 
                var sum = 0;
                for(var i=0; i<cols; i++){
                    sum += ( 'undefined' === typeof(board[ Number(query[1]) * rows + i]) ) ? 0 : board[ Number(query[1]) * rows + i];
                }
                console.log(sum);
                break;
        }//
    }
});