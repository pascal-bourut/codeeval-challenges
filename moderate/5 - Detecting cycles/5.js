// https://www.codeeval.com/open_challenges/5/

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var cnt = tmp.length;
        var i = cnt;
        var streak = [];
        // console.log(line);
        while(i--){
            var j = i;
            while(j--){
                var tmp_i = tmp[i];
                var tmp_j = tmp[j];
                // console.log('i',i, 'j',j, tmp_i, tmp_j);
                if( tmp_i == tmp_j ){
                    var si = i;
                    var sj = j;
                    streak.push(tmp_i);
                    for(var k = 1, max = (i < j ? i : j) ; k <= max ; k++){
                        var tmp_i_k = tmp[si-k];
                        var tmp_j_k = tmp[sj-k];
                        // console.log('k',k, 'ik',si-k,'jk',sj-k,tmp_i_k, tmp_j_k);
                        if( tmp_i_k == tmp_j_k ){
                            if( -1 === streak.indexOf(tmp_i_k) ){
                                streak.push(tmp_i_k);
                            }
                            // console.log('streak on!');
                            i--;
                            j--;
                        }
                        else{
                            // console.log('oops, break...');
                            break;
                        }
                    }
                }
            }
        }
        console.log(streak.reverse().join(' '));
        
    }
});
