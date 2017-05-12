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

namespace SmartyGettext\Console\Command;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Extract extends Command {
	protected function configure() {
		$this
			->setName('extract')
			->setDescription('Extract POT strings')
			->addArgument('arguments', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Files/Directories to scan')
			->addOption('--output', '-o', InputOption::VALUE_REQUIRED, 'Output filename')
			->setHelp(
				<<<EOT
<info>%command.full_name% -o template.pot <filename or directory> <file2> <..></info>

If a parameter is a directory, the template files within will be parsed.

The script rips gettext strings from Smarty file,
and prints them to stdout in already gettext encoded format, which you can
later manipulate with standard gettext tools.

EOT
			);
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$args = $input->getArgument('arguments');
		$files = $this->findFiles($args);

		$output->writeln('<info>Done</info>');
	}

	private function findFiles($args) {
		$files = array();

		$finder = new Finder();
		$finder
			->files()
			->name('*.tpl');

		foreach ($args as $arg) {
			if (is_dir($arg)) {
				$finder->in($arg);
			} elseif (is_file($arg)) {
				$files[] = new SplFileInfo($arg,null, null);
			} else {
				throw new InvalidArgumentException("Not file or dir: $arg");
			}
		}

		if ($files) {
			$finder->append($files);
		}

		return $finder;
	}
}
