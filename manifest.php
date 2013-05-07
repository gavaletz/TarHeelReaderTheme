<?php
/*
Template Name: Manifest
*/
header('Content-Type: text/cache-manifest');
require('state.php');

$fav_url = favorites_url();
parse_str($fav_url,$output);
$favorites = explode(",", $output['favorites']);
$size = count($favorites);
$domain = "http://gbserver3.cs.unc.edu";


echo "CACHE MANIFEST\n";
echo $fav_url."&offline=1"."\n";
echo $fav_url."\n";
echo "/theme/style.css\n";
echo "/theme/images/FavoriteYesIcon.png\n";
echo "/theme/images/well.png\n";
echo "/theme/images/settings.png\n";
echo "/theme/images/0stars_t.png\n";
echo "/theme/images/1stars_t.png\n";
echo "/theme/images/1.5stars_t.png\n";
echo "/theme/images/2stars_t.png\n";
echo "/theme/images/2.5stars_t.png\n";
echo "/theme/images/3stars_t.png\n";
echo "/theme/images/reviewed_t.png\n";
echo "/theme/images/BackArrow.png\n";
echo "/theme/images/NextArrow.png\n";


for($i=0; $i<$size; $i++){
	$post = get_post($favorites[$i]);
	$book = ParseBookPost($post);
	echo "/book-as-json/?slug=".$book['slug']."\n";
	$bookPages = $book['pages'];
	$numPages = count($bookPages);
	for($j = 0; $j <$numPages+1; $j++){
		$pageArray = $bookPages[$j];
		echo pageLink($book['link'], $j+1)."\n";
		echo $pageArray['url']."\n";
	}
}

echo "NETWORK:\n";
echo "*\n";

echo "FALLBACK:\n";
echo "/ ".$fav_url."\n";
?>
