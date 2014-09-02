// https://www.codeeval.com/open_challenges/138/

var track = false;
var cars = [];

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        if( !track ){
            track = line.split(' ');
        }
        else{
            var tmp = line.split(' ');
            var car  = {
                'id': tmp[0],
                'top_speed': tmp[1] / 3600,  // seconds
                'time_to_accelerate_top': tmp[2],
                'time_to_brake_zero': tmp[3],
                'lap_time': 0
            };
            car.accelerate_rate = car.top_speed / car.time_to_accelerate_top;
            car.brake_rate = car.top_speed / car.time_to_brake_zero;
            cars.push(car);    
        }
    }
});

var nb = cars.length;
for( var j = 0 ; j < nb ; j++ ){
    var car = cars[j];
    var time = 0;
    var speed_start_of_section = 0;

    for( var i = 0, cnt = track.length ; i < cnt ; i+=2 ){
        var section_length = track[i];
        var angle_factor = 1 - track[i+1] / 180;
        var ts = car.top_speed;
        var a = car.accelerate_rate;
        var b = car.brake_rate;

        var speed_end_of_section = angle_factor * ts;

        // accelerate phase from $speed_start_of_section to $top_speed => time and distance
        var t = ( ts - speed_start_of_section ) / a;
        // Linear distance can be expressed as (if acceleration is constant):
        // s = v0 t + 1/2 a t2
        var d = speed_start_of_section * t + ( a * t * t ) * 0.5;

        section_length -= d;
        time += t;

        // brake phase from $top_speed to $speed_end_of_section => time and distance
        t = ( ts - speed_end_of_section) / b;
        d = ts * t - (b * t * t) * 0.5; // caution: minus here

        section_length -= d;
        time += t;

        // top speed during (section_length - accelerate_phase.distance - brake_phase.distance) => time
        time += section_length / ts;

        speed_start_of_section = speed_end_of_section;
    }//

    cars[j].lap_time = time;
}

cars.sort(function(a,b){
    return a.lap_time - b.lap_time;
});

for( var j = 0 ; j < nb ; j++ ){
    console.log( cars[j].id + ' ' + cars[j].lap_time.toFixed(2) );
}
