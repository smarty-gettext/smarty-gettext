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

class LocaleTest extends TestCase {

	public function testPlural() {
		$this->setupLocale("et_EE");
		$this->locale(array('path' => self::$i18ndir, 'domain' => 'issue6'));

		// first form: 1 item
		$params = array('plural' => '%1 files', 'count' => 1);
		$res = $this->t('%1 file', $params);
		$this->assertEquals('1 fail', $res);

		// second form: 5 items
		$params = array('plural' => '%1 files', 'count' => 5);
		$res = $this->t('%1 file', $params);
		$this->assertEquals('%1 faili', $res);

		// 0 itesm: second form is used
		$params = array('plural' => '%1 files', 'count' => 0);
		$res = $this->t('%1 file', $params);
		$this->assertEquals('%1 faili', $res);
	}

	/**
	 * @dataProvider dataProvider_en_US
	 */
	public function testlLocaleTestMissingValues($exp, $input, $params) {
		$this->setupLocale("en_US");

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages'));
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	/**
	 * @dataProvider dataProvider_pl_PL
	 */
	public function testLocale($exp, $input, $params) {
		$this->setupLocale("pl_PL");

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages'));
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	public function testLocaleTestPreservingEnvironment() {
		$this->setupLocale("pl_PL");

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages', 'stack' => 'push'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! ", $res);

		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages2'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! - messages2", $res);

		$this->locale(array('stack' => 'pop'));
		$res = $this->t("Welcome! ", array());
		$this->assertEquals("Witaj! ", $res);
	}

	public function dataProvider_pl_PL() {
		return array(
			array("Witaj! ", "Welcome! ", array()),
			array("Na mojej stronie", "To my site ", array()),
			array("Nazwa mojej strony", "My site name", array())
		);
	}

	public function dataProvider_en_US() {
		return array(
			array("Welcome en_US!", "Welcome! ", array()),
			array("To my site", "To my site", array()),
			array("My site name en_US", "My site name", array())
		);
	}
}
