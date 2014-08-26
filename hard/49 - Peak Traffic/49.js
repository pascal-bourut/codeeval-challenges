// https://www.codeeval.com/open_challenges/49/

var one_way = {};
        
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split("\t");
        var a = tmp[1];
        var b = tmp[2];
        if( 'undefined' == typeof(one_way[a]) ){
            one_way[a] = {};
        }
        one_way[a][b] = true;
    }
});

// console.log(one_way);

var potential_clusters = {};

for( var k in one_way ){
    var cluster = [];
    cluster.push(k);
    var v = one_way[k];
    for( var kk in v ){
        cluster.push(kk);
    }
    if( cluster.length >= 3 ){
        cluster.sort();
        cluster = cluster.join(', ');
        potential_clusters[ cluster ] = true;
    }
}
// console.log( potential_clusters );

var clusters = [];
for( var users in potential_clusters ){
    var u = users.split(', ');
    var nb = u.length;
    var score = 0;
    var max = nb * (nb-1);
    for(var i=0;i<nb;i++){
        for(var j=0;j<nb;j++){
            if( i != j ){
                if( 'undefined' !== typeof(one_way[u[i]]) && 'undefined' !== typeof(one_way[u[i]][u[j]]) ){
                    score++;
                }
            }
        }
    }
    
    if( score == max ){
        var found = false;
        for( var i=0, nb = clusters.length ; i < nb ; i++){
            // no subset
            var pos = clusters[i].indexOf(users);
            if( pos !== -1 ){
                // I found a super-cluster
                found = true;
                break;
            }

            pos = users.indexOf(clusters[i]);
            if( pos !== -1 ){
                // I'm a super-cluster !
                clusters[i] = users;
                found = true;
                break;
            }

        }
        if( !found ){
            clusters.push( users );
        }
    }
}
// console.log(clusters);
clusters.sort();
// print_r($clusters);
console.log( clusters.join("\n") );
