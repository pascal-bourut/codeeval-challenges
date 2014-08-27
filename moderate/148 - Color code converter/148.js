// https://www.codeeval.com/open_challenges/148/

var hue2rgb = function(p, q, t){
    if(t < 0) t += 1;
    if(t > 1) t -= 1;
    if(t < 1/6) return p + (q - p) * 6 * t;
    if(t < 1/2) return q;
    if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
    return p;
};

var hsl_to_rgb = function(hsl){
    var h = Number(hsl[0] / 360);
    var s = Number(hsl[1] / 100);
    var l = Number(hsl[2] / 100);
    
    var r, g, b;

    if(s === 0){
        r = g = b = l; // achromatic
    }else{
        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        var p = 2 * l - q;
        r = hue2rgb(p, q, h + 1/3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1/3);
    }

    return {'r': Math.round(r * 255), 'g': Math.round(g * 255), 'b': Math.round(b * 255) };
};

var hsv_to_rgb = function(hsv){
    var h = Number(hsv[0] / 360);
    var s = Number(hsv[1] / 100);
    var v = Number(hsv[2] / 100);
    
    var r, g, b;

    var i = Math.floor(h * 6);
    var f = h * 6 - i;
    var p = v * (1 - s);
    var q = v * (1 - f * s);
    var t = v * (1 - (1 - f) * s);
    
    switch(i % 6){
        case 0: r = v, g = t, b = p; break;
        case 1: r = q, g = v, b = p; break;
        case 2: r = p, g = v, b = t; break;
        case 3: r = p, g = q, b = v; break;
        case 4: r = t, g = p, b = v; break;
        case 5: r = v, g = p, b = q; break;
    }
    
    return {'r': Math.round(r * 255), 'g': Math.round(g * 255), 'b': Math.round(b * 255) };
};

var cmyk_to_rgb = function(cmyk){
    var c = cmyk[0];
    var m = cmyk[1];
    var y = cmyk[2];
    var k = cmyk[3];
    
    var r = ( 1 - (c * (1 - k)) - k ) * 255;
 	var g = ( 1 - (m * (1 - k)) - k ) * 255;
 	var b = ( 1 - (y * (1 - k)) - k ) * 255;
      
    if( r<0 ) r = 0 ;
    if( g<0 ) g = 0 ;
    if (b<0 ) b = 0 ;
      
    return {'r': Math.round(r), 'g': Math.round(g), 'b': Math.round(b) };
}; //cmyk_to_rgb

var hex_to_rgb = function(hex){
    var int = parseInt( hex, 16 );
    return {'r': 0xFF & (int >> 0x10), 'g': 0xFF & (int >> 0x8), 'b': 0xFF & int};
};//hex_to_rgb


var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var rgb = false;
        if( line.indexOf('#') === 0 ){
            // hex
            rgb = hex_to_rgb( line.substr(1) );
        }
        else if( null !== (matches = line.match(/^(HSL|HSV|RGB|)?\((.*)\)$/) ) ){
            var c = matches[2].split(',');
            switch( matches[1] ){
                case 'HSL' : 
                    rgb = hsl_to_rgb(c);
                    break;
                case 'HSV' : 
                    rgb = hsv_to_rgb(c);
                    break;
                default : 
                    rgb = cmyk_to_rgb(c);
                    break;
            }//
        }
        if( rgb ){
            console.log( 'RGB(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')' );
        }
    }//
});