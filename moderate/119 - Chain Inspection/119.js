// https://www.codeeval.com/open_challenges/119/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(/[;\-]/);
        var pairs = {};
        var i = tmp.length;
        var max = i / 2;
        while( (i = i-2)>=0 ){
            pairs[ tmp[i] ] = tmp[i+1];
        }
                        
        i = 0;
        step = 'BEGIN';
        do{
            step = pairs[ step ];
            i++;
        }
        while( step != 'END' && i <= max );
                       
        console.log ( ( 'END' == step ) && ( i == max ) ? 'GOOD' : 'BAD' );
    }
});