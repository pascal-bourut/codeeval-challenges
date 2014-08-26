// https://www.codeeval.com/open_challenges/69/

var find_count = function(str, sub, depth, pos){
    var count = 0;
    
    // find $sub[$depth] into $str with starting point >= $pos
    var needle = sub.charAt( depth );
    var len = str.length;
    var sublen = sub.length;
    
    for( var i = pos ; i < len ; i++ ){
        if( str.charAt(i) == needle ){
            if( depth < (sublen-1) ){
                count += find_count(str, sub, depth+1, i+1);
            }
            else{
                count ++;
            }
        }
    }
    
    return count;
};

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        var str = tmp[0];
        var sub = tmp[1];
        console.log( find_count(str, sub, 0, 0) );
    }
});
