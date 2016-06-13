<?php

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