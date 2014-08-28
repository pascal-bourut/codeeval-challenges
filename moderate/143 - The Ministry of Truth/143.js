// https://www.codeeval.com/open_challenges/143/

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(';');
        var a = tmp[0];
        var result = a.split('');
        var a_len = a.length;
        var b = tmp[1].split(' ');
        var offset = -1;
        var pos = -1;
        var found = 0;
        var len = b.length;
        // console.log(line);
        for(var i=0; i < len ; i++){
            if( -1 != ( pos = a.indexOf( b[i] , offset+1 ) ) ){
                var b_len = b[i].length;
                // console.log(b[i], pos, offset);
                
                for(var j = offset ; j < pos ; j++){
                    if( a[j] != ' ' ){
                        result[j] = '_';
                    }
                    else{
                        result[j] = ' ';
                    }
                }
                
                offset = pos + b_len;
                found++;
            }
        }
        if( found == len ){
            for(var j = offset ; j < a_len ; j++){
                if( a[j] != ' ' ){
                    result[j] = '_';
                }
                else{
                    result[j] = ' ';
                }
            }
            console.log(result.join('').replace(/\s+/g,' '));
        }
        else{
            console.log('I cannot fix history');
        }
        
    }
});
