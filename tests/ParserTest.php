<?php

/*
 * This file is part of the smarty-gettext package.
 *
 * @copyright (c) Elan Ruusamäe
 * @license GNU Lesser General Public License, version 2.1
 * @see https://github.com/smarty-gettext/smarty-gettext/
 *
 * For the full copyright and license information,
 * please see the LICENSE and AUTHORS files
 * that were distributed with this source code.
 */

class ParserTest extends TestCase {
	// path to data dir
	private static $datadir;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		self::$datadir = __DIR__ . '/data';
	}

	/**
	 * @dataProvider testData
	 * @test
	 */
	public function testParse($input, $output) {
		$res = $this->tsmarty2c($input);
		$res = $this->stripPaths($res);
		$this->assertEquals($output, $res);
	}

	public function testData() {
		// $input, $output
		return array(
			$this->getFiles(1),
			$this->getFiles(2),
			$this->getFiles(3),
		);
	}

	/**
	 * @dataProvider testContextData
	 * @test that tsmarty2c is able to parse {t context} properly
	 */
	public function testContext($input, $output) {
		$res = $this->tsmarty2c($input);
		$res = $this->stripPaths($res);
		$this->assertEquals($output, $res);
	}

	public function testContextData() {
		// $input, $output
		return array(
			$this->getFiles(5)
		);
	}

	private function stripPaths($content) {
		$content = str_replace(self::$datadir, '<DATADIR>', $content);

		return $content;
	}

	private function getFiles($number) {
		return array($this->getFileName($number, "html"), $this->stripPaths($this->getFile($number, "pot")));
	}

	private function getFileName($number, $ext) {
		$datadir = __DIR__ . '/data';
		$file = $datadir . "/$number.$ext";

		return $file;
	}

	private function getFile($number, $ext) {
		$file = $this->getFileName($number, $ext);
		$this->assertFileExists($file);
		$content = file_get_contents($file);
		$this->assertNotEmpty($content);
		$content = trim($content);
		$this->assertNotEmpty($content);

		return $content;
	}
}
