<?php 

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;



class GetContentCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pl:fetch';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get content from Stack Overflow';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */

	// private $postrepo;

	public function __construct()
	{
		parent::__construct();
		
	}
	

	/**
	 * When a command should run
	 * Runs at 05.35 AM IST
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		
		return $scheduler->daily()->hours(5)->minutes(35);
          
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		 
		self::getContentInTable();		

		Log::info("Fetched the content successfully " );

	}

	/**
	 * Get Content from StackOverflow
	 *	 
	 */

	public static function getContentInTable(){

			$categories = Category::all();

			$today_timestamp = Carbon::today()->timestamp;

			foreach ($categories as $category) {

				$url = self::getURL($category->name, $today_timestamp);
								
				$client = new GuzzleHttp\Client();
			
				$response = $client->get($url);
			
				$obj = json_decode($response->getBody(), true);

				self::storeItem($obj['items'], $category->id);				

			}
	
	}

	/**
	 * Get Correct StackOverflow URL 
	 *
	 * @param string $name
     * @param int $timestamp
	 * @return string $url
	 */

	public static function getURL($name, $timestamp){

		$url = "https://api.stackexchange.com/2.2/questions?order=desc";
		$url .= "&tagged=" . $name;
		$url .= "&fromdate=" . $timestamp;			
		$url .= "&sort=creation&site=stackoverflow";

		return $url;

	}

	/**
	 * Save retrieved item in DB 
	 *
	 * @param array $items
     * @param int $category_id
	 * @return void
	 */

	public static function storeItem($items,$category_id){

		foreach ($items as $item) {

			$content = new Content();
			$content->category_id = $category_id;
			$content->is_answered = $item['is_answered'];
			$content->answer_count = $item['answer_count'];
			$content->view_count = $item['view_count'];
			$content->save();
					
		}

	}

	

}
