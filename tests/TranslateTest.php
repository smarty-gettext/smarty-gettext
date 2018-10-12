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

class TestTranslate extends TestCase {

	/**
	 * @dataProvider testData
	 * @test
	 */
	public function translateTest($exp, $input, $params) {
		$res = $this->t($input, $params);
		$this->assertEquals($exp, $res);
	}

	public function testData() {
		// string $expected, string $input, array $params
		return array(
			array('tere tali', 'tere %1', array('1' => 'tali')),

			// various escapes
			array('kommivabrik &quot;kalev&quot;', 'kommivabrik "kalev"', array()),
			array('kommivabrik &quot;kalev&quot;', 'kommivabrik "kalev"', array('escape' => 'html')),
			array("kommivabrik \'kalev\'", "kommivabrik 'kalev'", array('escape' => 'js')),
			array('kommivabrik \"kalev\"', 'kommivabrik "kalev"', array('escape' => 'js')),
			array('kommivabrik+%22kalev%22', 'kommivabrik "kalev"', array('escape' => 'url')),
			array("kommivabrik+%27kalev%27", "kommivabrik 'kalev'", array('escape' => 'url')),

			// slashes
			array("Check from \\\\smb\\myshare", "Check from \\\\smb\\myshare", array('escape' => 'html')),
			array("\t\\r\\nCheck from \\\\\\\\smb\\\\myshare", "\t\r\nCheck from \\\\smb\\myshare", array('escape' => 'js')),
			array('Type in \"\\\\server.name\\\\share\\\\\" and press enter', 'Type in "\\server.name\share\" and press enter', array('escape' => 'js')),

			// encodings
			array('mägra õlu on otsas, &lt;b&gt;kes&lt;/b&gt; poodi läheb?', 'mägra õlu on otsas, <b>kes</b> poodi läheb?', array('escape' => 'html')),
			array("юнит<br />\nтест", "%1\n%2", array('1' => 'юнит', 2 => 'тест')),
		);
	}
}
