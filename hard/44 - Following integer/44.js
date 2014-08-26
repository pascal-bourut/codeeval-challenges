// https://www.codeeval.com/open_challenges/44/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var len = line.length;
        var i = len;
        var digits = [];
        var prev = 0;
        var result = '';
        // I travel across the string right to left
        while( i-- ){
            var curr = Number(line.charAt(i));
            if( curr >= prev ){
                // if current element bigger than prev element, I keep this for later into [digits]
                digits.push(curr);
                prev = curr;
            }
            else{
                // if current element lower than prev element
                // I will switch this element with the lowest of [digits]
                digits.sort();
                var min = prev;
                var idx = 0;
                for( var j = 0, nb = digits.length ; j < nb ; j++ ){
                    digit = digits[j];
                    if( digit > curr ){
                        min = digit;
                        idx = j;
                        break;
                    }//
                }//
                digits[idx] = curr;
                // result : unparsed digits + min + other digits ordered
                result = line.substr(0, i) + min + digits.join('');
                break;
            }
        }

        if( !result ){
            // no result
            // I look for the lower digit by not zero
            // result will be: lower + 0 + other digits ordered
            digits.sort();
            for(var i=0, nb = digits.length ; i < nb ; i++){
                var digit = digits[i];
                if( digit > 0 ){
                    delete digits[i];
                    result = digit + '0' + digits.join('');
                    break;
                }
            }
        }
        console.log(result);
    }
});