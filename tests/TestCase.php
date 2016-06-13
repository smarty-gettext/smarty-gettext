<?php

class TestCase extends PHPUnit_Framework_TestCase {

	/** @var string */
	protected static $i18ndir;

	/** @var string */
	private static $tsmarty2c;

	public static function setUpBeforeClass() {
		self::setupGettext();
		self::setupParser();
	}

	/**
	 * wrap {t} block for testing
	 *
	 * @param string $text
	 * @param array $params
	 * @return string
	 */
	protected function t($text, $params) {
		return smarty_block_t($params, $text);
	}

	/**
	 * wrap {locale} function for testing
	 *
	 * @param $params
	 */
	protected function locale($params) {
		$smarty = self::getSmarty();
		smarty_function_locale($params, $smarty);
	}

	/**
	 * init locale for $locale, always UTF-8
	 *
	 * @param string $locale
	 * @param int $category
	 */
	protected function setupLocale($locale, $category = LC_ALL) {
		$locale_utf8 = "$locale.UTF-8";
		$res = setlocale($category, $locale_utf8);
		$this->assertEquals($locale_utf8, $res);
	}

	/**
	 * Create Smarty object.
	 * Can handle Smarty 2.6/3.1
	 *
	 * @return Smarty
	 */
	private static function getSmarty($template_dir = '') {
		$smarty = new Smarty();

		if (method_exists($smarty, 'getTemplateDir')) {
			$smarty->setTemplateDir($template_dir);
		} else {
			$smarty->template_dir = $template_dir;
		}

		return $smarty;
	}

	/**
	 * build *.mo for each *.po
	 * setup $i18ndir class variable
	 */
	private static function setupGettext() {
		self::$i18ndir = __DIR__ . '/i18n';
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

	private static function setupParser() {
		self::$tsmarty2c = __DIR__ . '/../tsmarty2c.php';
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

	/**
	 * Run tsmarty2c
	 *
	 * @param string $input
	 * @return string output from the command
	 */
	protected function tsmarty2c($input) {
		// this may be empty if setupBeforeClass override does not invoke parent
		$this->assertNotEmpty(self::$tsmarty2c);

		$cmd = array();
		$cmd[] = escapeshellcmd(self::$tsmarty2c);
		$cmd[] = escapeshellarg($input);

		exec(join(' ', $cmd), $lines, $rc);
		$this->assertEquals(0, $rc, "command ran okay");
		$this->assertNotEmpty($lines);

		$res = join("\n", $lines);
		$this->assertNotEmpty($res);

		return $res;
	}
}
