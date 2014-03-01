<?php
/** @file PasswdGen.php - Provides `GenPasswd` class.
 * Copyright (C) 2014 Zachary Scott <zscott.dev@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

require dirname(__FILE__).'/WordList.php';

/**
 * Simple password generator.
 *
 * @author Zachary Scott <zscott.dev@gmail.com>
 */
class PasswdGen {

	private $wordList;

	public function __construct() {
		$this->wordList = new WordList();
	}
	
	/** Generates and output the given the . */
	public function gen($n = 10) {
	
		for (; $n > 0; $n--) {

			switch (mt_rand() % 3) {
				case 0:
					$passwd = $this->short();
					break;
				case 1:
					$passwd = $this->symbols();
					break;
				case 2:
					$passwd = $this->limerick();
					break;			
			}
			
			echo "$passwd\n";
			
		}	
	
	}	
	
	/** Generates a short password with two words and a few digits. */
	public function short() {

		$wordList = $this->wordList;		
		$passwd = $wordList->word() . $wordList->word();		

		// add some random digits
		for ($n = 0; $n < 3; $n++)
			$passwd .= mt_rand(0, 9);

		return $passwd;

	}	
	
	/** 
	 * Generates a password (same as that from `short()`) which includes substitutes
	 * some letters for symbols.
	 */
	public function symbols() {
	
		$rep = array(
			'a' => '@',
			'E' => '3',
			'g' => '9',
			'i' => '!',
			'I' => '1',
			'l' => '1',
			'O' => '0',
			'S' => '$',
			't' => '+',
			'T' => '7',
			'z' => 2
		);

		$orig = $this->short();
		$passwd = '';
		
		for ($i = 0; $i < strlen($orig); $i++) {
			$ch = $orig[$i];
			
			if (array_key_exists($ch, $rep) && mt_rand() % 2) { // substitute
				$passwd .= $rep[$ch];
			} else { // verbatim
				$passwd .= $ch;
			}		
			
		}

		return $passwd;
	
	}
	
	/** Generates a password with five letters which are in the form of a limerick. */
	public function limerick() {
		
		$wordList = $this->wordList;
		
		// limerick words - scheme AABBA	
		$a = $wordList->word();
		$b = $wordList->soundsLike($a);
		$c = $wordList->word();
		$d = $wordList->soundsLike($c);
		$e = $wordList->soundsLike($a);
		
		return "$a$b$c$d$e";
		
	}
	
}
		
?>