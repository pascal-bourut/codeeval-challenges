// https://www.codeeval.com/open_challenges/117/

var faces = [
    {'w':[1,4], 'h':[2,5]}, /*front*/
    {'w':[1,4], 'h':[3,6]}, /*top*/
    {'w':[3,6], 'h':[2,5]} /*side*/
];

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split('|');
        var hole = tmp[0].replace(/[\[\]]/g,'').replace(' ',',').split(',');
        var bricks = tmp[1].split(';');
        
        var hole_w = Math.abs(hole[0] - hole[2]);
        var hole_h = Math.abs(hole[1] - hole[3]);
        
        // console.log(hole_w,hole_h);
                        
        var pass_through = [];
        var i = bricks.length;
        while(i--){
            var brick = bricks[i].replace(/[\(\)\[\]]/g,'').replace(/[ ]/g,',').split(',');
            // console.log(brick);
            var j=3;
            while(j--){
                var face_w = Math.abs(brick[faces[j].w[0]] - brick[faces[j].w[1]]);
                var face_h = Math.abs(brick[faces[j].h[0]] - brick[faces[j].h[1]]);
                // console.log(brick[0], hole_w, hole_h, face_w, face_h);
                if( (face_w <= hole_w && face_h <= hole_h)||(face_w <= hole_h && face_h <= hole_w) ){
                    // console.log('in hole');
                    pass_through.push( brick[0] );
                    break;
                }
            }
        }
        // console.log('pass_through',pass_through);
        
        pass_through.sort(function(a,b){return a-b;});
        console.log( pass_through.length ? pass_through.join(',') : '-' );
    }
});