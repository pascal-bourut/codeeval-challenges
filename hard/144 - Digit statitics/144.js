// https://www.codeeval.com/open_challenges/144/


var last_digits = {};
for(var i=2;i<=9;i++){
    var d = i;
    last_digits[i] = [d];
    while(true){
        d = Number((''+(d * i)).substr(-1));
        if( -1 !== last_digits[i].indexOf(d)  ){
            break;
        }
        else{
            last_digits[i].push( d );
        }
    }                    
}//



var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var a = Number(tmp[0]);
        var n = Number(tmp[1]);
        
        var ld = last_digits[a];
        var cnt = ld.length;
                       
        var stats = {};
        for(var k in ld){
            stats[ ld[k] ] = Math.ceil( (n - k) / cnt );
        }
        
        var result = [];
        for( var i=0 ; i<=9 ; i++ ){
            result.push( i + ': ' + ( 'undefined' !== typeof(stats[i]) ? stats[i] : 0 ) );
        }
        console.log( result.join(', ') );
    }
});