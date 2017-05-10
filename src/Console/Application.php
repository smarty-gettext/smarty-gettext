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

namespace SmartyGettext\Console;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication {
	protected function getDefaultCommands() {
		$commands = parent::getDefaultCommands();

		$commands[] = new Command\Extract();

		return $commands;
	}
}
