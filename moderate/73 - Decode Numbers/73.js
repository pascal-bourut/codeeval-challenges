// https://www.codeeval.com/open_challenges/73/


var decode_numbers = function( n ){
    var len = n.length;
    if( len <= 1 ){
        return 1;
    }
    else{
        var count = 0;
        for( var i=1 ; i <= 2 ; i++){
            var sub = n.substr(0, i);
            
            if( Number(sub) > 26 ){
                break; 
            }
            count += decode_numbers( n.substr(i) );
        }
        return count;
    }
};


var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
         console.log( decode_numbers( line ) );
    }
});