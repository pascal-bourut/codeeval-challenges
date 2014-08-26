var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(';');
        var words = tmp[0];
        var hints = tmp[1];
        
        words = words.split(' ');
        hints = hints.split(' ');
        
        var words_len = words.length;
        var hints_len = hints.length;
        var trans = {};
        for (var i=0; i < hints_len ; i++){
            trans[ hints[ i ] ] = words[ i ];
        }
         
        // console.log(trans);
        
        var out = '';
        for( var i=1 ; i <= hints_len + 1 ; i++){
            out += ( ('undefined' !== typeof(trans[i])) ? trans[i] : words[ words_len - 1] ) + ' ';
        }
        console.log( out.trim() );
    }
});
