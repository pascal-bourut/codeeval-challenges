<?php
header('Content-Type: text/plain; charset=utf-8');
// https://www.codeeval.com/open_challenges/15/
function isLittleEndian() {
    $testint = 0x00FF;
    $p = pack('S', $testint);
    return $testint===current(unpack('v', $p));
}
echo ( isLittleEndian() ? 'LittleEndian' : 'BigEndian' ) . "\n";
?>
