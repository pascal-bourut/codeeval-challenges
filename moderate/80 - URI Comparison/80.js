// https://www.codeeval.com/open_challenges/80/

var parse_url = /^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/;

var SCHEME = 1;
var HOST = 3;
var PORT = 4;
var PATH = 5;

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(';');
        var urls = [
            parse_url.exec(tmp[0]),
            parse_url.exec(tmp[1])
        ];
        
        for(var i=0 ; i < 2 ; i++){
            // 1. A port that is empty or not given is equivalent to the default port of 80 
            urls[i][PORT] = ( 'undefined' !== typeof(urls[i][PORT]) ) ? urls[i][PORT] : 80;
            // 2. Comparisons of host names MUST be case-insensitive 
            urls[i][SCHEME] = (urls[i][SCHEME]).toLowerCase();
            // 3. Comparisons of scheme names MUST be case-insensitive 
            urls[i][HOST] = (urls[i][HOST]).toLowerCase();
            // 4. Characters are equivalent to their % HEX HEX encodings. (Other than typical reserved characters in urls like , / ? : @ & = + $ #)
            urls[i][PATH] = ( 'undefined' !== typeof(urls[i][PATH]) ) ? decodeURIComponent((urls[i][PATH] + '').replace(/%(?![\da-f]{2})/gi, '%25')) : '';
            
            urls[i].hash = urls[i][SCHEME]+urls[i][HOST]+urls[i][HOST]+urls[i][PATH];
        }
        console.log( urls[0].hash == urls[1].hash ? 'True' : 'False'  );
    }
});