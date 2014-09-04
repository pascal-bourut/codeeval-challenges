// https://www.codeeval.com/open_challenges/90/

var M_PI = Math.PI;

function distance(lat1, lng1, lat2, lng2){
    var pi80 = M_PI / 180;
    lat1 *= pi80;
    lng1 *= pi80;
    lat2 *= pi80;
    lng2 *= pi80;

    var r = 6372.797; // mean radius of Earth in km
    var dlat = lat2 - lat1;
    var dlng = lng2 - lng1;
    var a = Math.sin(dlat * 0.5) * Math.sin(dlat * 0.5) + Math.cos(lat1) * Math.cos(lat2) * Math.sin(dlng * 0.5) * Math.sin(dlng * 0.5);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var km = r * c;

	return km;
}//

function commuting_engineer(prev, indexes, visited, curr_length, best, step ){
    
    // console.log('>',visited);
    if( visited === false ){
        visited = [];
    }
    else{
        var new_visited = [];
        for(var i in visited){
            new_visited.push(visited[i]);
        }
        visited = new_visited;
    }
    // console.log(prev, visited, best, step);
    visited.push(prev);
        
    // console.log('<',visited);
    
    if( step === 0 ){
        if( curr_length < best[0] ){
            best[0] = curr_length;
            best[1] = visited;
        }
    }
    else{
        for(var i in indexes){
            var next = indexes[i];
            // console.log(next,'visited['+next+']',visited[next]);
            if( -1 === visited.indexOf(next) ){
                var a,b;
                if( prev < next ){
                    a = prev;
                    b = next;
                }
                else{
                    b = prev;
                    a = next;
                }
                var d = distances[a+'-'+b];
                var next_length = curr_length + d;
                
                if( next_length < best[0] ){
                    best = commuting_engineer(next, indexes, visited, next_length, best, step - 1);
                }
            }
        }
    }
    return best;
}

var places = [];
var ids = [];
var distances = {};
                

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var matches = null;
        if( null !== ( matches = line.match(/^([0-9]+) \|.*\(([0-9\-\.]+), ([0-9\-\.]+)\)$/) ) ){
            places.push({
                'lat':matches[2],
                'lng':matches[3]
            });
            ids.push( Number(matches[1]) );
        }
    }
});

var cnt = places.length;
for( var i=0; i < cnt-1 ; i++){
    for(var j= i+1; j < cnt ; j++){
        var d = distance( places[i].lat, places[i].lng, places[j].lat, places[j].lng);
        var a,b;
        if( ids[i] < ids[j] ){
            a = ids[i];
            b = ids[j];   
        }
        else{
            a = ids[j];
            b = ids[i];   
        }
        
        distances[a+'-'+b] = d;
    }
}

// console.log(distances);

var best = commuting_engineer( 1, ids, false, 0, [Number.POSITIVE_INFINITY, false], ids.length-1 );
console.log(best[1].join("\n"));
