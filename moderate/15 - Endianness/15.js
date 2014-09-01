// https://www.codeeval.com/open_challenges/15/

function endianness () {
  var b = new ArrayBuffer(4);
  var a = new Uint32Array(b);
  var c = new Uint8Array(b);
  a[0] = 0xdeadbeef;
  if (c[0] == 0xef) return 'LittleEndian';
  if (c[0] == 0xde) return 'BigEndian';
  throw new Error('unknown endianness');
}
console.log( endianness() );
