<?php

namespace system\library;

 /**
 * pagination Class
 *
 * generate pagination page
 *
 * @package		system
 * @subpackage	library
 * @category	paging
 */

class pagination{

	// --------------------------------------------------------------------

	/**
	 * Generate pagination template
	 *
	 * sum all of page and generating paging template
	 *
	 * @return	mixed
	 */
	
	public function generate(
		$noPage = 1,
		$dataPerPage = 10,
		$jumData = 0,
		$url,
		$container_class = null,
		$list_class = null,
		$a_class = null,
		$pjax = null,
		$list_class_active = null,
		$other_attr = null
	){
		
		// url method detector
		if(strpos($url,"?") == true){

			$url = $url."&";

		}else{

			$url = $url."?";	

		}
		
		$offset = ($noPage - 1) * $dataPerPage;

		$list = "<ul class='".$container_class."'>";

		$jumPage = ceil($jumData/$dataPerPage);

		$list .= "<li class='".$list_class."'><a page='1' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=1' ".$other_attr.">First</a></li>";

		if ($noPage > 1) {

			$list .= "<li class='".$list_class."' ><a page='".($noPage-1)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".($noPage-1)."' ".$other_attr.">Prev</a></li>";

		}

			for($page = 1; $page <= $jumPage; $page++)
			{
					 if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 0) || ($page == 0))
					 {
						if ($page == $noPage){

							$list .= "<li> <a class='".$list_class_active."'>".$page."</a></li>";

						}else{

							$list .= "<li class='".$list_class."'> <a page='".($page)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".$page."' ".$other_attr.">".$page."</a> </li>";

						}

						$showPage = $page;
					 }
			}

			if ($noPage < $jumPage) {

				$list .= "<li class='".$list_class."'><a page='".($noPage+1)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".($noPage+1)."' ".$other_attr.">Next</a></li>";

			}

			$list .= "<li class='".$list_class."' ><a page='".($jumPage)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".($jumPage)."' ".$other_attr.">Last</a></li>";
			$list .= "</ul>";

		return $list;
	} 
}