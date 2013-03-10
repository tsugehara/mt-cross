<?php
// mt.php
// arrange by: http://homepage2.nifty.com/magicant/sjavascript/mt.html

/*

Mersenne Twister in JavaScript based on "mt19937ar.c"

 * JavaScript version by Magicant: Copyright (C) 2005 Magicant


 * Original C version by Makoto Matsumoto and Takuji Nishimura
   http://www.math.sci.hiroshima-u.ac.jp/~m-mat/MT/mt.html

Copyright (C) 1997 - 2002, Makoto Matsumoto and Takuji Nishimura,
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:

  1. Redistributions of source code must retain the above copyright
     notice, this list of conditions and the following disclaimer.

  2. Redistributions in binary form must reproduce the above copyright
     notice, this list of conditions and the following disclaimer in the
     documentation and/or other materials provided with the distribution.

  3. The names of its contributors may not be used to endorse or promote 
     products derived from this software without specific prior written 
     permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE COPYRIGHT OWNER OR
CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/

class MT {
	function __construct($seed=NULL) {
		if (empty($seed))
			$seed = time();
		$this->_mt = array_fill(0, 624, 0);
		$this->setSeed($seed);
	}

	static function urshift($value, $by){
		return $value >> $by;
	}

	static function _mulUint32($a, $b) {
		$a1 = $a >> 16;
		$a2 = $a & 0xffff;
		$b1 = $b >> 16;
		$b2 = $b & 0xffff;
		return ((($a1 * $b2 + $a2 * $b1) << 16) + $a2 * $b2);
	}
	static function _toNumber($x) {
		return ceil($x);
	}

	function setSeed($seed) {
		$mt_len = count($this->_mt);
		if (is_int($seed)) {
			$this->_mt[0] = $seed;
			for ($i = 1; $i < $mt_len; $i++) {
				$x = $this->_mt[$i-1] ^ ($this->_mt[$i-1] >> 30);
				$this->_mt[$i] = self::_mulUint32(1812433253, $x) + $i;
			}
			$this->_index = $mt_len;
		} else if (is_array($seed)) {
			$i = 1;
			$j = 0;
			$this->setSeed(19650218);

			for ($k = max($mt_len, count($seed)); $k > 0; $k--) {
				$x = $this->_mt[i-1] ^ ($this->_mt[i-1] >> 30);
				$x = self::_mulUint32($x, 1664525);
				$this->_mt[i] = ($this->_mt[i] ^ $x) + $seed[j] + $j;
				if (++$i >= mt_len) {
					$this->_mt[0] = $this->_mt[$mt_len-1];
					$i = 1;
				}
				if (++$j >= count($seed)) {
					$j = 0;
				}
			}
			for ($k = $mt_len - 1; $k > 0; $k--) {
				$x = $this->_mt[i-1] ^ ($this->_mt[i-1] >> 30);
				$x = self::_mulUint32($x, 1566083941);
				$this->_mt[i] = ($this->_mt[i] ^ $x) - $i;
				if (++$i >= $mt_len) {
					$this->_mt[0] = $this->_mt[$mt_len-1];
					$i = 1;
				}
			}
			$this->_mt[0] = 0x80000000;
		} else {
			throw new Exception("MersenneTwister: illegal seed.");
		}
	}

	function _nextInt() {
		$value;

		$mt_len = count($this->_mt);
		if ($this->_index >= $mt_len) {
			$k = 0;
			$N = $mt_len;
			$M = 397;
			do {
				$value = ($this->_mt[$k] & 0x80000000) | ($this->_mt[$k+1] & 0x7fffffff);
				$this->_mt[$k] = $this->_mt[$k+$M] ^ ($value >> 1) ^ (($value & 1) ? 0x9908b0df : 0);
			} while (++$k < $N-$M);
			do {
				$value = ($this->_mt[$k] & 0x80000000) | ($this->_mt[$k+1] & 0x7fffffff);
				$this->_mt[$k] = $this->_mt[$k+$M-$N] ^ ($value >> 1) ^ (($value & 1) ? 0x9908b0df : 0);
			} while (++$k < $N-1);
			$value = ($this->_mt[$N-1] & 0x80000000) | ($this->_mt[0] & 0x7fffffff);
			$this->_mt[$N-1] = $this->_mt[$M-1] ^ ($value >> 1) ^ (($value & 1) ? 0x9908b0df : 0);
			$this->_index = 0;
		}
		
		$value = $this->_mt[$this->_index++];
		$value ^=  $value >> 11;
		$value ^= ($value <<   7) & 0x9d2c5680;
		$value ^= ($value <<  15) & 0xefc60000;
		$value ^=  $value >> 18;
		return $value;
	}

	function nextInt($min, $sup) {
		if (!(0 < $sup && $sup < 0x100000000))
			return $this->_nextInt() + $min;
		if (($sup & (~$sup + 1)) == $sup)
			return (($sup - 1) & $this->_nextInt()) + $min;

		do {
			$value = $this->_nextInt();
		} while ($sup > 2147483647 - ($value - ($value %= $sup)));
		return $value + $min;
	}

	function next() {
		$a = $this->_nextInt() >> 5;
		$b = $this->_nextInt() >> 6;
		return ($a * 0x4000000 + $b) / 0x10000000000000; 
	}
}
?>