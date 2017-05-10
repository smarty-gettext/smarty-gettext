<?php

/*
 * This file is part of the smarty-gettext package.
 *
 * @copyright (c) Elan Ruusamäe
 * @license GNU Lesser General Public License, version 2.1 or any later
 * @see https://github.com/smarty-gettext/smarty-gettext/
 *
 * For the full copyright and license information,
 * please see the LICENSE and AUTHORS files
 * that were distributed with this source code.
 */

class MsgctxtTest extends TestCase {
	/**
	 * @dataProvider testData
	 * @test
	 */
	public function translateTest($exp, $input, $params) {
		$this->setupLocale("en_US");
		$this->locale(array('path' => self::$i18ndir, 'domain' => 'messages'));

		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	public function testData() {
		// string $expected, string $input, array $params
		return array(
			array('letter (symbol)', 'letter', array('context' => 'symbol')),
			array('letter (message)', 'letter', array('context' => 'message')),
		);
	}
}