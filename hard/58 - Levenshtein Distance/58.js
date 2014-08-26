// https://www.codeeval.com/open_challenges/58/

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


var words = [];
var word_list = {};
var eoi = false;

var find_friends = function(word, friends){
    var len = word.length;
    var new_friends = {};
    
    for( var l = len-1; l <= len+1; l++){
        if( 'undefined' !== typeof(word_list[l]) ){
            var list = word_list[l];
            var j = list.length;
            while(j--){
                var friend = list[j];
                if ( 'undefined' === typeof(friends[friend]) ){
                    var d = levenshtein(word, friend);
                    if( d == 1 ){
                        new_friends[friend] = true;
                        friends[friend] = true;
                    }
                }
            }
        }
    }//
    
    for(var friend in new_friends ){
        friends = find_friends( friend, friends );
    }
    
    return friends;
};

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        if( eoi ){
            var len = line.length;
            if( 'undefined' === typeof(word_list[len]) ){
                word_list[len] = [];
            }
            word_list[len].push( line );
        }   
        else if( line=='END OF INPUT' ){
            eoi = true;
        }
        else{
            words.push( line );
        }
    }
});

for( var i=0, cnt=words.length ; i < cnt ; i++){
    var result = find_friends(words[i], {} );
    var total = Object.keys(result).length;
    console.log( total ? total : 1);
}