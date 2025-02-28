<?php

namespace Mgahed\LaravelStarter\Commands;

use Illuminate\Console\Command;

class LaravelStarterCommand extends Command
{
	public $signature = 'test-starter';

	public $description = 'My command';

	public function handle(): int
	{
		$this->comment('All done');

		return self::SUCCESS;
	}
}
