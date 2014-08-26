// https://www.codeeval.com/open_challenges/52/

var trans = {
    '1': 'One',
    '2': 'Two',
    '3': 'Three',
    '4': 'Four',
    '5': 'Five',
    '6': 'Six',
    '7': 'Seven',
    '8': 'Eight',
    '9': 'Nine',
    '10': 'Ten',
    '11': 'Eleven',
    '12': 'Twelve',
    '13': 'Thirteen',
    '14': 'Fourteen',
    '15': 'Fifteen',
    '16': 'Sixteen',
    '17': 'Seventeen',
    '18': 'Eighteen',
    '19': 'Nineteen',
    '20': 'Twenty',
    '30': 'Thirty',
    '40': 'Forty',
    '50': 'Fifty',
    '60': 'Sixty',
    '70': 'Seventy',
    '80': 'Eighty',
    '90': 'Ninety',
    'pow2': 'Hundred',
    'pow5': 'Hundred',
    'pow8': 'Hundred',
    'pow3': 'Thousand',
    'pow6': 'Million',
    'pow9': 'Billion',
    '$': 'Dollars'
};


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var len = line.length;
        var i = len;
        var result = '';
        while( i-- ){
            var pos = len - i - 1;
            var modpos = pos % 3;
            var digit = line.charAt(i);

            if( 'undefined' !== typeof( trans['pow' + pos] ) ){
                                
                if( modpos == 2 ){
                    if( 'undefined' !== typeof( trans[digit] ) ){
                        result = trans[digit] + trans['pow' + pos] + result; // Hundred
                    }
                }
                else {
                    if( Number(line.substring( i-2, i+1 )) > 0 ){
                        result = trans['pow' + pos] + result; // Thousand, Million    
                    }
                }
            }

            if( modpos == 0 ){
                // 0, 3, 6, 9
                
                if( '' !== line.charAt(i-1) ){
                    i--;
                    tens = line.charAt(i);
                }
                else{
                    tens = '0';
                }

                // echo $digit.', '.$tens."\n";

                if( digit == '0' ){
                    if( tens != '0' ){ // e.g.: 10, 30, 60
                        result = trans[tens + digit] + result;
                    }
                }
                else{
                    if( tens == '0' ){  // e.g.: 01, 03, 06
                        result = trans[ digit ] + result;
                    }
                    else if( tens == '1' ){ // e.g.: 11, 13, 16
                        result = trans[ '1' + digit ] + result;
                    }
                    else{ // e.g.: 23, 46, 79
                        result = trans[ tens+'0'] + trans[ digit ] + result;
                    }
                }
            }

        }
        console.log( result + trans['$'] );
    }
});