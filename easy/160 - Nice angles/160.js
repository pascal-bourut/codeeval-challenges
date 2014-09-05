// https://www.codeeval.com/open_challenges/160/


function decimal_to_sexagesimal( decimal ){
    if( decimal < 0 ) decimal = -decimal;
    var deg = decimal | 0;
    var min = (decimal - deg) * 60;
    var sec = (min - (min|0)) * 60;
    
    min = min|0;
    if( min < 10 ) min = '0' + min;
    sec = sec|0;
    if( sec < 10 ) sec = '0' + sec;
    
    return deg + '.' + min + "'" + sec + '"';
}

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        console.log( decimal_to_sexagesimal(line) );
    }
});