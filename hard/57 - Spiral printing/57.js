// https://www.codeeval.com/open_challenges/57/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var tmp = line.split(';');
        var rows = Number(tmp[0]);
        var cols = Number(tmp[1]);
        var data = tmp[2].split(' ');
        
        var result = '';
        var xmin = 0;
        var ymin = 0;
        var xmax = cols - 1;
        var ymax = rows - 1;
        var direction = 0;
        var steps = xmax - xmin;
        var x = -1;
        var y = 0;
        for( var i=0, len = rows * cols; i < len ; i++){
            switch(direction){
                case 0 : // left-to-right
                    x++;
                    if( steps == 0 ){
                        direction = 1;
                        ymin++;
                        steps = ymax - ymin + 1;
                    }
                    break;
                case 1 : // top-to-bottom
                    y++;
                    if( steps == 0 ){
                        direction = 2;
                        xmax--;
                        steps = xmax - xmin + 1;
                    }
                    break;
                case 2 : // right-to-left
                    x--;
                    if( steps == 0 ){
                        direction = 3;
                        ymax--;
                        steps = ymax - ymin + 1;
                    }
                    break;
                case 3 : // bottom-to-top
                    y--;
                    if( steps == 0 ){
                        direction = 0;
                        xmin++;
                        steps = xmax - xmin + 1;
                    }
                    break;
            }//

            result += ' ' + data[y * cols + x];
            steps--;
        }//
        console.log(result.trim());
        
    }
});