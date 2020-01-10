<?php 
function get_date($time,$fulltime = true)
{
	$fomat = '%d-%m-%Y';
	if($fulltime)
	{
		$fomat = $fomat.' -%H:%i:%s';
	}
	$date = mdate($fomat,$time);
	return $date;
}
?>