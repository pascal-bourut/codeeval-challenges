// https://www.codeeval.com/open_challenges/14/

var permut = function( chars, used ){
    var all = [];
    var chars_len = chars.length;
    var used_len = used.length;
    for( var i=0; i < chars_len ; ++i){
        var char = chars[i];
        if( -1 == used.indexOf(char) ){
            if( used_len == (chars_len-1) ){
                return used.join('') + char;
            }
            else{
                var next_used = [];
                for(var j=0; j < used_len ; ++j ){
                    next_used.push(used[j]);
                }
                next_used.push(char);
                
                var word = permut( chars, next_used );
                all.push( word );
            }
        }
    }//for
    return all;
};

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var result = '';
        var chars = line.split('');
        chars.sort();
        var all = permut( chars , [] );
        console.log(all.join(','));
    }
});