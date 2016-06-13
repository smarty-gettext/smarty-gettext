<?php

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
	 * @test
	 */
	public function testContenxt($input, $output) {
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
