<?php 

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;


class DeleteDBContentCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pl:delete';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove old content from Table';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */


	public function __construct()
	{
		parent::__construct();
		
	}
	
	/**
	 * When a command should run
	 * Runs at 05.30 AM IST
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */

	public function schedule(Schedulable $scheduler)
	{
		
		return $scheduler->daily()->hours(5)->minutes(30);
	}

	/**
	 * Execute the console command.
	 *
	 * Truncates the content Table
	 *
	 * @return mixed
	 */
	public function fire()
	{
			
		Content::truncate();	

		Log::info("Removed all entries in the content table" );
		
	}

	
}
