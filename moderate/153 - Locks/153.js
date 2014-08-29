// https://www.codeeval.com/open_challenges/153/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var n = Number(tmp[0]);
        var m = Number(tmp[1]);
        
        var unlocked = n;
        if( m == 1 ){
            unlocked -= 1;
        }
        else{
            // There are "n" unlocked rooms located in a row along a long corridor.
            var locks = 0; 
            // m-1 passes
            for( var j = 1 ; j <= n ; j++ ){
                var div2 = j%2 === 0;
                var div3 = j%3 === 0;
                var lock = false;
                if( div2 && div3 ){
                    // 0
                }
                else if( div2 ){
                    lock = true;
                }
                else if( div3 ){
                    if( (m-1)%2!==0 ){
                        lock = true;
                    }
                }

                if( j == n ){
                    // last pass (switch lock)
                    lock = !lock;
                }

                if( lock ){
                    locks++;
                }
            }
            unlocked -= locks;
        }

        console.log(unlocked);
        
    }
});