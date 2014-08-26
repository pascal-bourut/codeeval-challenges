var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var out = '';
        var tmp = line.split(',');
        var n = parseInt(tmp[0]);
        var s = tmp[1];
        
        var base = [];
        var i = s.length;
        while(i--){
            var chr = s.charAt(i);
            if( base.indexOf( chr ) == -1 ){
                base.push(chr);
            }
        }
        base.sort().reverse();
        
        var base_cnt = base.length;
        if( base_cnt == 1 ){
            out = new Array( n+1 ).join(base[0]); // str_repeat
        }
        else{
            var base_max = new Array( n+1 ).join( base_cnt-1 );
            var max = parseInt(base_max + '', base_cnt | 0).toString(10 | 0); // base_convert X => 10
            // console.log('base_cnt',base_cnt,'base_max',base_max,'max',max);
            var i = parseInt(max) + 1;
            while( i-- ){
        
                // base convert 10 => base_cnt
                var r = i % base_cnt;
                var test = base[r];
                var k = n-1;
                var q = Math.floor(i/base_cnt);
                while (q) {
                    r = q % base_cnt;
                    q = Math.floor(q/base_cnt);
                    test = base[r]+test;
                    k--;
                }
                
                // padding left
                if( k > 0 ){
                    test = new Array( k+1).join( base[0] ) + test;
                }
                
                if( out != '' ){
                    out += ',';
                }
                
                out += test;
            }
        }
        console.log(out);
    }
});
