<?php

class TestLocale extends PHPUnit_Framework_TestCase {

	/** @var string */
	private static $i18ndir;

	public static function setUpBeforeClass() {
		self::setupGettext();
	}

	/**
	 * @dataProvider testData_en_US
	 * @test
	 */
	public function localeTestMissingValues($exp, $input, $params) {
		$language = "en_US";
		putenv("LANG=" . $language);
		setlocale(LC_ALL, $language);
		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages'));
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	/**
	 * @dataProvider testData_pl_PL
	 * @test
	 */
	public function localeTest($exp, $input, $params) {
		$language = "pl_PL";
		putenv("LANG=" . $language);
		setlocale(LC_ALL, $language);
		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages'));
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	/**
	 * @test
	 */
	public function localeTestPreservingEnvironment() {
		$language = "pl_PL";
		putenv("LANG=" . $language);
		setlocale(LC_ALL, $language);

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages', 'stack' => 'push'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! ", $res);

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages2'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! - messages2", $res);

		$this->locale(array('path' => self::$i18ndir, 'stack' => 'pop'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! ", $res);
	}

	/**
	 * @param string $text
	 * @param array $params
	 * @return string
	 */
	private function t($text, $params) {
		return smarty_block_t($params, $text);
	}

	private function locale($params) {
		$smarty = new stdClass();
		$smarty->template_dir = '';
		smarty_function_locale($params, $smarty);
	}

	public function testData_pl_PL() {
		return array(
			array("Witaj! ", "Welcome! ", array()),
			array("Na mojej stronie", "To my site ", array()),
			array("Nazwa mojej strony", "My site name", array())
		);
	}

	public function testData_en_US() {
		return array(
			array("Welcome en_US!", "Welcome! ", array()),
			array("To my site", "To my site", array()),
			array("My site name en_US", "My site name", array())
		);
	}

	/**
	 * build *.mo for each *.po
	 * setup $i18ndir class variable
	 */
	private static function setupGettext() {
		self::$i18ndir = __DIR__ . '/data/i18n';
		foreach (glob(self::$i18ndir . '/*/LC_MESSAGES/*.po') as $pofile) {
			$pofile = new SplFileInfo($pofile);
			$mofile = $pofile->getPath() . '/' . $pofile->getBasename('.po') . '.mo';

			$mofile = new SplFileInfo($mofile);
			if ($mofile->isFile() && $mofile->getMTime() > $pofile->getMTime()) {
				continue;
			}

			self::msgfmt($pofile, $mofile);
		}
	}

	/**
	 * run msgfmt checking it's error code
	 *
	 * @param string $input
	 * @param string $output
	 */
	private static function msgfmt($input, $output) {
		passthru('msgfmt ' . escapeshellarg($input) . ' -o ' . escapeshellarg($output), $rc);
		self::assertEquals(0, $rc, "msgcat $input -> $output");
	}
}
