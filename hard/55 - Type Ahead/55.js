// https://www.codeeval.com/open_challenges/55/

var text = 'Mary had a little lamb its fleece was white as snow;\
And everywhere that Mary went, the lamb was sure to go.\
It followed her to school one day, which was against the rule;\
It made the children laugh and play, to see a lamb at school.\
And so the teacher turned it out, but still it lingered near,\
And waited patiently about till Mary did appear.\
"Why does the lamb love Mary so?" the eager children cry; "Why, Mary loves the lamb, you know" the teacher did reply."';

text = text.replace(/[^A-Za-z ]/g,' ').trim();
var words = text.split(/\s+/);
var cnt = words.length;

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        
        var tmp = line.split(',');
        var n = Number(tmp[0]);
        var user_words = tmp[1].split(' ');
        
        var total = 0;
        var next = {};
        for(var i = 0; i < cnt-n-1; i++){
            var ok = true;
            for(var j = 0; j < n-1; j++){
                ok = ok && ( words[i+j] == user_words[j] );
            }
            if( ok ){
                if( 'undefined' == typeof(next[ words[i+n-1] ]) ){
                    next[ words[i+n-1] ] = 0;
                }
                next[ words[i+n-1] ]++;
                total++;
            }
        }
        
        var tosort = [];
        for( var k in next ){
            tosort.push({k:k,v:next[k]});
        }
        tosort.sort(function(a,b){
             if( a.v == b.v ){
                return a.k < b.k ? -1 : 1;
            }
            else{
                return b.v - a.v;
            }
        });
        // console.log(tosort);
        
        var result = [];
        for( var i=0, nb = tosort.length; i < nb ; i++){
            result.push(tosort[i].k + ',' + (tosort[i].v / total).toFixed(3) );
        }
        console.log(result.join(';'));
        
    }
});