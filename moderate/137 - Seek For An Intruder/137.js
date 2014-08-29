// https://www.codeeval.com/open_challenges/137/

function hexdec(hex_string) {
    hex_string = (hex_string + '').replace(/[^a-f0-9]/gi, '');
    return parseInt(hex_string, 16);
}
function bindec(binary_string) {
    binary_string = (binary_string + '').replace(/[^01]/gi, '');
    return parseInt(binary_string, 2);
}
function octdec(oct_string) {
    oct_string = (oct_string + '').replace(/[^0-7]/gi, '');
    return parseInt(oct_string, 8);
}
function decbin(number) {
    if (number < 0) {
        number = 0xFFFFFFFF + number + 1;
    }
    return parseInt(number, 10).toString(2);
}

var ips = {};
var patterns = {
    'dotted_hexa_pattern': /(0x[1-f][0-f]|0x0[1-f]|0x[1-f])\.(0x[0-f]{2}|0x0)\.(0x[0-f]{2}|0x0)\.(0xf[0-e]|0x[1-e][0-f]|0x0[0-f]|0x0)/,
    'dotted_binary_pattern': /([0-1]{7}1|[0-1]{6}1[0-1]|[0-1]{5}1[0-1]{2}|[0-1]{4}1[0-1]{3}|[0-1]{3}1[0-1]{4}|[0-1]{2}1[0-1]{5}|[0-1]1[0-1]{6}|1[0-1]{7})\.([0-1]{8})\.([0-1]{8})\.([0-1]{7}0|[0-1]{6}0[0-1]|[0-1]{5}0[0-1]{2}|[0-1]{4}0[0-1]{3}|[0-1]{3}0[0-1]{4}|[0-1]{2}0[0-1]{5}|[0-1]0[0-1]{6}|0[0-1]{7})/,
    'dotted_octal_pattern': /(0[1-3][0-7]{2}|00[1-7][0-7]|000[1-7])\.(0[1-3][0-7]{2}|00[0-7]{2})\.(0[1-3][0-7]{2}|00[0-7]{2})\.(037[0-6]|03[0-6][0-7]|0[1-2][0-7]|00[0-7]{2})/,
    'dotted_decimal_pattern': /(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])\.(25[0-4]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])/,
    'hexa_pattern': /0x([1-f][0-f]|0[1-f]|[1-f])([0-f]{2}|0)([0-f]{2}|0)(f[0-e]|[1-e][0-f]|0[0-f]|0)/,
    'binary_pattern': /([0-1]{7}1|[0-1]{6}1[0-1]|[0-1]{5}1[0-1]{2}|[0-1]{4}1[0-1]{3}|[0-1]{3}1[0-1]{4}|[0-1]{2}1[0-1]{5}|[0-1]1[0-1]{6}|1[0-1]{7})([0-1]{8})([0-1]{8})([0-1]{7}0|[0-1]{6}0[0-1]|[0-1]{5}0[0-1]{2}|[0-1]{4}0[0-1]{3}|[0-1]{3}0[0-1]{4}|[0-1]{2}0[0-1]{5}|[0-1]0[0-1]{6}|0[0-1]{7})/,
    'octal_pattern': /(3777777777[0-6]|377777777[0-6][0-7]|37777777[0-6][0-7]{2}|3777777[0-6][0-7]{3}|377777[0-6][0-7]{4}|37777[0-6][0-7]{5}|3777[0-6][0-7]{6}|377[0-6][0-7]{7}|37[0-6][0-7]{8}|3[0-6][0-7]{9}|[1-2][0-7]{10}|[1-7][0-7]{8})/,
    'decimal_pattern': /(429496729[0-4]|42949672[0-8][0-9]|4294967[0-2][0-9]{2}|429496[0-7][0-9]{3}|42949[0-6][0-9]{4}|4294[0-8][0-9]{5}|429[0-3][0-9]{6}|42[0-8][0-9]{7}|4[0-1][0-9]{8}|[1-9][0-9]{8}|1677721[6-9]|167772[2-9][0-9]|16777[3-9][0-9]{2}|1677[8-9][0-9]{3}|167[8-9][0-9]{4}|16[8-9][0-9]{5}|1[7-9][0-9]{6}|[2-9][0-9]{7})/
};

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        for( var name in patterns ){
            var pattern = patterns[name];
            var matches = null;
            if( null !== ( matches = line.match(pattern) ) ){
                // console.log(name, matches);   
                var ip = false;
                var bin = false;
                var bin_len = 0;
                switch( name ){
                    case 'dotted_hexa_pattern' :
                        ip = hexdec(matches[1]) + '.' + hexdec(matches[2]) + '.' + hexdec(matches[3]) + '.' + hexdec(matches[4]);
                    break;
                    case 'dotted_binary_pattern' :
                        ip = bindec(matches[1])+'.'+bindec(matches[2])+'.'+bindec(matches[3])+'.'+bindec(matches[4]);
                    break;
                    case 'dotted_octal_pattern' :
                        ip = octdec(matches[1])+'.'+octdec(matches[2])+'.'+octdec(matches[3])+'.'+octdec(matches[4]);
                    break;
                    case 'dotted_decimal_pattern' :
                        ip = matches[1]+'.'+matches[2]+'.'+matches[3]+'.'+matches[4];
                    break;
                    case 'hexa_pattern' :
                        ip = hexdec(matches[1])+'.'+hexdec(matches[2])+'.'+hexdec(matches[3])+'.'+hexdec(matches[4]);
                    break;
                    case 'binary_pattern' :
                        ip = bindec(matches[1])+'.'+bindec(matches[2])+'.'+bindec(matches[3])+'.'+bindec(matches[4]);
                    break;
                    case 'octal_pattern' :
                        bin = decbin(octdec(matches[1]));
                        bin_len = bin.length;
                        if( bin_len < 32 ) {
                            bin = new Array( 32 - bin_len +1 ).join('0') + bin;
                        }
                        ip = bindec(bin.substr(0,8))+'.'+bindec(bin.substr(8,8))+'.'+bindec(bin.substr(16,8))+'.'+bindec(bin.substr(24,8));
                    break;
                    case 'decimal_pattern' :
                        bin = decbin(matches[1]);
                        bin_len = bin.length;
                        if( bin_len < 32 ) {
                            bin = new Array( 32 - bin_len +1 ).join('0') + bin;
                        }
                        ip = bindec(bin.substr(0,8))+'.'+bindec(bin.substr(8,8))+'.'+bindec(bin.substr(16,8))+'.'+bindec(bin.substr(24,8));
                    break;                                    
                }
                if( ip ){
                    if( 'undefined' === typeof(ips[ip]) ){
                        ips[ip] = 0;
                    }
                    ips[ip]++;
                }
            }
        }
    }
});

var new_ips = [];
for(var ip in ips){
    new_ips.push({ip: ip, v: ips[ip]});
}

new_ips.sort( function(a,b){
    if( a.v == b.v ){
        return b.ip - a.ip;
    }
    else{
        return b.v - a.v;
    }
});

var max = new_ips[0].v;

var result = '';
for(var i=0, cnt=new_ips.length; i < cnt ; i++){
    var ip = new_ips[i];
    if( ip.v == max ){
        if( result !== '' ) result += ' ';
        result += ip.ip;
    }
    else{
        break;
    }
}

console.log(result);