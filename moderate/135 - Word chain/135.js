// https://www.codeeval.com/open_challenges/135/


function word_chain(nodes, key, used , max ){
    if( 'undefined' !== typeof(nodes[key]) ){
        var new_max = max;
        for( var i=0, cnt = nodes[key].length ; i < cnt ; i++){
            var word = nodes[key][i];
            if( 'undefined' === typeof(used[word]) ){
                var next_used = {};
                for(var k in used){
                    next_used[k] = true;
                }
                next_used[ word ] = true;
                var m = word_chain( nodes, word.substr(-1,1) , next_used, max + 1);
                if( m > new_max ){
                    new_max = m;
                }
            }
        }
        max = new_max;
    }
    return max;
}

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var max = 0;
        var nodes = {};
        var words = line.split(',');
        var len = words.length;
        var i = len;
        while(i--){
            var word = words[i];
            if( 'undefined' === typeof(nodes[word[0]]) ){
                nodes[word[0]] = [];
            }
            nodes[ word[0] ].push( word );
        }

        for(var k in nodes){
            var result = word_chain( nodes, k , {}, 0);
            if( result > max ){
                max = result;
            }
        }
        console.log( max > 1 ? max : 'None' );
    }
});