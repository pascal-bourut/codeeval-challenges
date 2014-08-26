// https://www.codeeval.com/open_challenges/136/

var old_pos = false,
    way = '';
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var choice = 'C';
        var pos = line.indexOf( choice );
        if( pos == -1 ){
            choice = '_';
            pos = line.indexOf( choice );
        }
        if( old_pos === false || pos == old_pos ){
            way = '|';
        }
        else if( pos < old_pos ){
            way = '/';
        }
        else if( pos > old_pos ){
            way = '\\';
        }
        line = line.split(choice).join(way);
        old_pos = pos;
        console.log(line);
    }
});