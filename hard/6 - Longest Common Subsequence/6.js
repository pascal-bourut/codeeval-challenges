// https://www.codeeval.com/open_challenges/6/

// http://en.wikipedia.org/wiki/Longest_common_subsequence_problem

function longest_common_subsequence(a, b){
    var lengths = [];
    var a_len = a.length;
    var b_len = b.length;
    
    var i,j;
    for( i=0 ; i <= a_len ; i++ ){
        lengths[i] = [];
        for( j=0 ; j <= b_len ; j++ ){
            lengths[i][j] = 0;
        }
    }
 
    for( i = 0; i < a_len ; i++){
        for(j = 0; j < b_len ; j++){
            if( a[i] == b[j] ){
                lengths[i+1][j+1] = lengths[i][j] + 1;
            }
            else{
                lengths[i+1][j+1] = (lengths[i+1][j] > lengths[i][j+1]) ? lengths[i+1][j] : lengths[i][j+1];
            }
        }
    }
    
    var result = '';
    for( var x = a_len, y = b_len; x !== 0 && y !== 0; ) {
        if (lengths[x][y] == lengths[x-1][y]){
            x--;
        }
        else if (lengths[x][y] == lengths[x][y-1]){
            y--;
        }
        else {
            result = a[x-1] + result;
            x--;
            y--;
        }
    }
 
    return result;
}//longest_common_subsequence


var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(';');
        var a = tmp[0];
        var b = tmp[1];
        
        
        // I remove characters which are not in both strings
        var aa = a.split('');
        var bb = b.split('');
        var aa_len = aa.length;
        for(var i=0 ; i < aa_len ; i++){
            if( -1 == bb.indexOf(aa[i]) ){
                aa[i] = '';
            }
        }
        var bb_len = bb.length;
        for(var j=0 ; j < bb_len ; j++){
            if( -1 == aa.indexOf(bb[j]) ){
                bb[j] = '';
            }
        }
        a = aa.join('');
        b = bb.join('');
        
        
        // console.log( line, a, b );
        console.log( longest_common_subsequence(a, b) );
    }
});