<?php

class TestLocale extends TestCase {
	/**
	 * @dataProvider testData_en_US
	 * @test
	 */
	public function localeTestMissingValues($exp, $input, $params) {
		$this->setupLocale("en_US");

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages'));
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	/**
	 * @dataProvider testData_pl_PL
	 * @test
	 */
	public function localeTest($exp, $input, $params) {
		$this->setupLocale("pl_PL");

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages'));
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	/**
	 * @test
	 */
	public function localeTestPreservingEnvironment() {
		$this->setupLocale("pl_PL");

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
