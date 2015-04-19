<?php

class TestCase extends PHPUnit_Framework_TestCase {

	/** @var string */
	protected static $i18ndir;

	public static function setUpBeforeClass() {
		self::setupGettext();
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
		$smarty = new stdClass();
		$smarty->template_dir = '';
		smarty_function_locale($params, $smarty);
	}

	/**
	 * init locale for $locale, always UTF-8
	 *
	 * @param string $locale
	 * @param int $category
	 */
	protected function setupLocale($locale, $category = LC_ALL) {
		$language = "$locale.UTF-8";
		setlocale($category, $language);
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
