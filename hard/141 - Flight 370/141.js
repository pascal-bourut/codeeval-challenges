// https://www.codeeval.com/open_challenges/141/

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


function placemark_cmp(a, b){
    if( a.nb == b.nb ){
        if( a.ts >b.ts ) return -1;
        if( a.ts < b.ts ) return 1;
        if( a.ts == b.ts ) return a.id - b.id;
    }
    return b.nb - a.nb;
}

var in_xml = false,
    regions = [],
    placemarks = [],
    in_placemark = false,
    id = 0,
    nb = 0,
    lon = 0,
    lat = 0,
    ts = 0,
    n = '';

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        if( -1 !== line.indexOf('<?xml version="1.0"') ){
            in_xml = true;
        }
        else if( in_xml ){
            var pos = line.indexOf('Placemark');
            if( pos !== -1 ){
                var c = line[pos-1];
                if( c == '<' ){
                    in_placemark = true;
                    id = Number(line.substr(pos+14, line.lastIndexOf('"') - pos - 14));
                }
                else if( c == '/' ){
                    in_placemark = false;
                    placemarks.push({
                        'id': id,
                        'name': n,
                        'ts': ts,
                        'lon': lon,
                        'lat': lat,
                        'nb': nb
                    });
                    id = nb = lon = lat = ts = 0;
                    n = '';
                }
            }
            else if( in_placemark ){
               
                if( ( -1 !== (from = line.indexOf('<name>'))) && ( -1 !== (to = line.indexOf('</name>', from))) ){
                    n = line.substr( from+6, to-from-6);
                }
                else if( ( -1 !== (from = line.indexOf('Confirmation: <b>'))) && ( -1 !== (to = line.indexOf('</b>', from))) ){
                    nb = Number( line.substr(from+17, to-from-17) );
                }
                else if( ( -1 !== (from = line.indexOf('<TimeStamp><when>'))) && ( -1 !== (to = line.indexOf('</when></TimeStamp>', from))) ){
                    ts = line.substr(from+17, to-from-17);
                }
                else if( ( -1 !== (from = line.indexOf('<Point><coordinates>'))) && ( -1 !== (to = line.indexOf('</coordinates></Point>', from))) ){
                    var tmp = line.substr(from+20, to-from-20).split(',');
                    lon = tmp[0];
                    lat = tmp[1];
                }

            }
        }
        else {
            var km_lon_lat = line.split(/[;\(\) ,]+/);
            regions.push({
                'km': km_lon_lat[0],
                'lon': km_lon_lat[1],
                'lat': km_lon_lat[2]
            });
        }
    }
});

var regions_cnt = regions.length;
var placemarks_cnt = placemarks.length;
placemarks.sort(placemark_cmp);
                
for(var i=0 ; i < regions_cnt ; i++){
    var region = regions[i];
    var km = region.km;
    var lng1 = region.lon;
    var lat1 = region.lat;

    var max = 0;
    var placemarks_ok = [];
    for( var j=0 ; j < placemarks_cnt ; j++){
        var placemark = placemarks[j];
        var lng2 = placemark.lon;
        var lat2 = placemark.lat;
        var nb = placemark.nb;
        if( nb >= max ){
            if( distance(lat1, lng1, lat2, lng2) <= km ){
                if( nb > max ){
                    placemarks_ok = [];
                }
                placemarks_ok.push( placemark );
                max = nb;
            }
        }
        else{
            break;
        }
    }
    if( placemarks_ok.length ){
        var result = '';
        for(var k=0, cnt = placemarks_ok.length ; k < cnt ; k++){
            result += ( k > 0 ? ', ' : '' ) + placemarks_ok[k].name;
        }
        console.log(result);
    }
    else{
        console.log('None');
    }
}