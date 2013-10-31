<?php

require_once dirname(__FILE__) . '/../block.t.php';

class TestTranslate extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider testData
	 * @test
	 */
	public function translateTest($exp, $input, $params) {
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

	public function testData() {
		// $input, $output
		return array(
			array('tere tali', 'tere %1', array('1' => 'tali')),
		);
	}
}
