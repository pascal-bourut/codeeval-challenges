// https://www.codeeval.com/open_challenges/53/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        
        var most_used_phrase = '';
        var length = 0;

        var len = line.length;
        for (var i = 0; i < len; i++) {
            for ( var j = 0; j < len-i+1; j++) {
                var current_phrase = line.substr(i, j);
                // console.log('current_phrase',current_phrase);
                if (current_phrase !== '') {
                    var current_phrase_length = current_phrase.length;
                    if (current_phrase_length > length) {
                        // console.log(current_phrase_length,'>',length);
                        var offset = -current_phrase_length;
                        var substr_count = 0;
                        while ((offset = line.indexOf(current_phrase, offset + current_phrase_length )) != -1) {
                            substr_count++;
                        }
                        // console.log('substr_count('+line+','+current_phrase+')', substr_count);
                        if ( substr_count > 1 ) {
                            most_used_phrase = current_phrase;
                            length = current_phrase_length;
                            /*
                            console.log('most_used_phrase', most_used_phrase);
                            console.log('length', length);
                            */
                        }
                    }
                }
            }
        }
        
        if ( '' === most_used_phrase.replace(/ /g,'') ) {
            most_used_phrase = 'NONE';
        }
        console.log( most_used_phrase );
    }
});