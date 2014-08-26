var ugly_numbers = function (str) {
    var ugly_count = 0;
    var digits_cnt = str.length;
    
    if( digits_cnt == 1 ){
        // str = Math.round(str);
        // if(str < 0) str *= -1;
        if( (str==0) || ((str%2)==0) || ((str%3)==0) || ((str%5)==0) || ((str%7)==0) ){
            ugly_count++;
        }
    }
    else{
        var digits = [];
        var i;
        for(i=0;i<digits_cnt;i++){
            digits[i] = str.charAt(i);
        }
        
        var frombase = 3;
        var tobase = 10;
        var number = '';
        i = digits_cnt - 1;
        while( i-- ){
            number = number + '2';
        }
        // console.log('number',number);
        var max = parseInt(number + '', frombase | 0).toString(tobase | 0);
        // console.log('max',max);
        // console.log('digits', digits);
        var base = ['0','1','2'];
        i = parseInt(max) + 1;
        while( i-- ){
            
            var r = i % 3;
            var test = base[r];
            var k = 0;
            var q = Math.floor(i/3);
            while (q) {
                r = q % 3;
                q = Math.floor(q/3);
                test = base[r]+test;
                k++;
            }
            
            // console.log(test);
            
            var sum = 0;
            var tmp = '';
            var j = digits_cnt;
            while( j-- ){
                tmp = '' + digits[j] + tmp;
                if( (test[k] !== undefined) && (test[k]!='0') ){
                    if( test[k] == '2' ){
                        tmp = '-' + tmp;
                    }
                    sum += Math.round(tmp);
                    tmp = '';
                }
                k--;
            }
            if( tmp ){
                sum += Math.round(tmp);
            }
            // console.log(sum);
            
            sum = Math.round(sum);
            // if( sum < 0 ) sum = -sum;
            
            
            if( (sum==0) || ((sum%2)==0) || ((sum%3)==0) || ((sum%5)==0) || ((sum%7)==0) ){
                ugly_count++;
            }
        }   
    }
    return ugly_count;
};

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if ( line != '' ) {
        console.log( ugly_numbers(line) );
    }
});