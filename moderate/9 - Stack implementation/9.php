<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/9/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

class Stack{
    private $data = array();
    private $size = 0;
    
    function push($el){
        $this->data[] = $el;
        $this->size++;
    }
    function pop(){
        $el = $this->data[ $this->size - 1 ];
        $this->size--;
        return $el;
    }
    function is_empty(){
        return $this->size==0 ? true : false;
    }
}

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $stack = new Stack();
                        $numbers = explode(' ', $line);
                        for($i=0, $cnt=count($numbers); $i < $cnt; $i++){
                            $stack->push( $numbers[$i] );
                        }
                        $even = true;
                        $out = array();
                        while( !$stack->is_empty() ){
                            $el = $stack->pop();
                            if( $even ){
                                $out[] = $el;
                            }
                            $even = !$even;
                        }
                        echo implode(' ',$out)."\n";
                    }
                    
                }//
                fclose( $fp );
            }
            else{
                echo '!fp'."\n";
            }
        }
        else{
            echo '!readable'."\n";
        }
    }
    else{
        echo '!file_exists'."\n";
    }
}
else{
    echo '!argv[1]'."\n";
}

exit(0);

?>
