// https://www.codeeval.com/open_challenges/126/

function levenshtein(s1, s2) {
    if (s1 == s2) {
        return 0;
    }
    var l1 = s1.length;
    var l2 = s2.length;
  
    if (l1 === 0) {
        return l2;
    }
    if (l2 === 0) {
        return l1;
    }
    var p1 = new Array(l2 + 1);
    var p2 = new Array(l2 + 1);

    var i1, i2, c0, c1, c2, tmp;
  
    for (i2 = 0; i2 <= l2; i2++) {
        p1[i2] = i2;
    }
  
    for (i1 = 0; i1 < l1 ; i1++) {
        p2[0] = p1[0] + 1;
    
        for (i2 = 0; i2 < l2; i2++) {
            c0 = p1[i2] + ((s1[i1] == s2[i2]) ? 0 : 1);
            c1 = p1[i2 + 1] + 1;
      
            if (c1 < c0) {
                c0 = c1;
            }
      
            c2 = p2[i2] + 1;
      
            if (c2 < c0) {
                c0 = c2;
            }
      
            p2[i2 + 1] = c0;
        }
    
        tmp = p1;
        p1 = p2;
        p2 = tmp;
    }
  
    c0 = p1[l2];
  
    return c0;
}


function segment_cmp(a, b){
    if( a[1] == b[1] ){
        return a[0].localeCompare(b[0]);
    }
    else{
        return a[1] - b[1];
    }
}


var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var segment = tmp[0];
        var mismatches = Number(tmp[1]);
        var dna = tmp[2];
        var dna_len = dna.length;
        var segment_len = segment.length;
        var unsorted = [];
        for( var i=0, max = dna_len - segment_len ; i <= max ; i++ ){
            var sub = dna.substr(i, segment_len);
            var dist = levenshtein(segment, sub);
            if( dist <= mismatches ){
                unsorted.push([sub, dist]); 
            }
        }
        if( unsorted.length > 0 ){
            unsorted.sort(segment_cmp);
            // console.log(unsorted);
            var result = [];
            for(var i=0, cnt=unsorted.length; i < cnt ; i++){
                result.push(unsorted[i][0]);
            }
            console.log( result.join(' ') );
        }
        else{
            console.log('No match');
        }
    }
});
