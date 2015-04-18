<?php

class TestLocale extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider testData_en_US
	 * @test
	 */
	public function localeTestMissingValues($exp, $input, $params) {
		$language = "en_US";
		putenv("LANG=" . $language);
		setlocale(LC_ALL, $language);
		$this->locale(array('path' => __DIR__ . '/data/i18n', 'domain' => 'messages'));
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
		$this->locale(array('path' => __DIR__ . '/data/i18n', 'domain' => 'messages'));
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
		$this->locale(array('path' => __DIR__ . '/data/i18n', 'domain' => 'messages', 'stack' => 'push'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! ", $res);
		$this->locale(array('path' => __DIR__ . '/data/i18n', 'domain' => 'messages2'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! - messages2", $res);
		$this->locale(array('path' => __DIR__ . '/data/i18n', 'stack' => 'pop'));
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
}
