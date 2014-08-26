// https://www.codeeval.com/open_challenges/130/
console.error('trop lent');
return; 
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' ');
        var binary_seq = tmp[0];
        var string_seq = tmp[1];
                        
        // 1 => (A|B)+
        // 0 => A+
        
        var pattern = '';
        var len = binary_seq.length;
        for(var i=0;i<len;i++){
            if( binary_seq.charAt(i) == '0' ){
                pattern += 'A+';
            }
            else{
                pattern += '(A+|B+)';
            }
        }
        
        var regexp = new RegExp(pattern);
        // console.log(pattern);
        var result = regexp.test( string_seq );
        console.log( result ? 'Yes' : 'No' );
    }
});