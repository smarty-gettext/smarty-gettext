<?php

require_once dirname(__FILE__) . '/../block.t.php';
require_once dirname(__FILE__) . '/../function.locale.php';

class TestLocale extends PHPUnit_Framework_TestCase {
	
	/**
	 * @dataProvider testData_pl_PL
	 * @test
	 */
	public function localeTest($exp, $input, $params) {
		$language = "pl_PL";
		putenv("LANG=" . $language); 
		setlocale(LC_ALL, $language);
		$this->locale(['path' => __DIR__ . '/data/i18n', 'domain' => 'messages']);
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	/**
	 * @dataProvider testData_en_US
	 * @test
	 */
	public function localeTestMissingValues($exp, $input, $params) {
		$language = "en_US";
		putenv("LANG=" . $language); 
		setlocale(LC_ALL, $language);
		$this->locale(['path' => __DIR__ . '/data/i18n', 'domain' => 'messages']);
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
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
		$var = null;
		smarty_function_locale($params, $var);
	}

	public function testData_pl_PL() {
		return [
		["Witaj! ", "Welcome! ", []],
		["Na mojej stronie", "To my site ", []],
		["Nazwa mojej strony", "My site name", []]
		];
	}

	public function testData_en_US() {
		return [
		["Welcome en_US!", "Welcome! ", []],
		["To my site", "To my site", []],
		["My site name en_US", "My site name", []]
		];
	}
}
