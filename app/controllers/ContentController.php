<?php



class ContentController extends BaseController {

	/**
    * To Get Graphical Statistics Page
    * 
    * @return pages.index View
    */

	public function view()
	{
		$contents = Content::all();

		$categories = Category::all()->toArray();
		
		$output_arr = array();
		
		foreach($contents as $content) {
		    $index = self::tag_exists($content['category_id'], $output_arr);
		    if ($index < 0) {
		        $output_arr[] = $content;
		    }
		    else {
		    	$output_arr[$index]['questions'] += 1 ;
		        $output_arr[$index]['is_answered'] +=  $content['is_answered'];
		        $output_arr[$index]['answer_count'] +=  $content['answer_count'];
		        $output_arr[$index]['view_count'] +=  $content['view_count'];
		    }
		}		

		return View::make('pages.index')->withOutput($output_arr)->withCategories($categories);	

	}


	/**
    * To Search for existing tag in the array
    *
    * @param int $category_id
    * @param int $array
    * @return $result
    */

	public static function tag_exists($category_id, $array) {
		    $result = -1;
		    for($i=0; $i<sizeof($array); $i++) {
		        if ($array[$i]['category_id'] == $category_id) {
		            $result = $i;
		            break;
		        }
		    }
		    return $result;
		}

}
