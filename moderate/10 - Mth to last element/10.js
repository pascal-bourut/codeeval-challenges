// https://www.codeeval.com/open_challenges/10/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var len = tmp.length;
        var nth = false;
        var i = len;
        while(i--){
            if( nth === false ){
                nth = Number(tmp[i]);
                if( nth >= len ){
                    break;
                }
                else{
                    nth = len - nth - 1;
                }
            }
            else if( i == nth ){
                console.log(tmp[i]);
                break;
            }
        }
        
        /*
        // OR 
        
        var tmp = line.split(' ');
        var cnt = tmp.length;
        var mth = Number(tmp.pop());
        if(mth < cnt){
            console.log( tmp[cnt-mth-1] );
        }
        
        */
    }
});