import java.io.File;
import java.io.BufferedReader;
import java.io.FileReader;
import java.util.Hashtable;
import java.util.Set;

public class Main {
    public static void main (String[] args) {
        try{
            File file = new File(args[0]);
            BufferedReader in = new BufferedReader(new FileReader(file));
            String line;
            while ((line = in.readLine()) != null) {

                String[] tmp = line.split(";");

                String str = tmp[0];
                String[] sub = tmp[1].split(",");

                Hashtable replaced = new Hashtable();
                int first = 2;

                int cnt = sub.length;
                int i = 0;
                for( i = 0 ; i < cnt ; i+= 2 ){
                    String replacement = "" + (first + replaced.size());
                    replaced.put(replacement, sub[i+1] );
                    str = str.replaceAll( sub[i] , replacement );
                }

                Set<String> keys = replaced.keySet();
                for(String key: keys){
                    str = str.replaceAll( key , "" + replaced.get(key) );
                }   

                System.out.println( str );
            }
        }catch( Exception e ){
            System.out.println(e.getMessage());
        }
    }
}
