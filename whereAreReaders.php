<?php
/*
Template Name: Where are readers
*/
?>
<?php

$us_state_abbrevs_names = array(
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AS'=>'American Samoa',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FM'=>'Federated States of Micronesia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'GU'=>'Guam Gu',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MH'=>'Marshall Islands',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'MP'=>'Northern Mariana Islands',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PW'=>'Palau',
    'PA'=>'Pennsylvania',
    'PR'=>'Puerto Rico',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VI'=>'Virgin Islands',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',
    'AE'=>'Armed Forces Africa \ Canada \ Europe \ Middle East',
    'AA'=>'Armed Forces America (except Canada)',
    'AP'=>'Armed Forces Pacific'
);

$userID = get_current_user_id();
$mine = getParam('mine', 0, '/1/') == '1';

$base = ABSPATH;

if ($userID && $mine) {
    $mapname = "$base/Maps/map_$userID.json";
} else {
    $mapname = "$base/Maps/map_0.json";
}
$exists = file_exists($mapname);
$view = array(
  'user' => $userID,
  'mine' => $mine,
  'exists' => $exists
  );

if ($exists) {
    $content = file_get_contents($mapname);
    $map = json_decode($content, true);
    $countries = array();
    foreach($map['countries'] as $country=>$count) {
        $countries[] = array('name' => $country, 'count' => number_format($count));
    }
    sort($countries);
    $states = array();
    foreach($map['states'] as $state=>$count) {
        $states[] = array('name' => $us_state_abbrevs_names[$state], 'count' => number_format($count));
    }
    sort($states);
    $view['countries'] = $countries;
    $view['country_count'] = count($countries);
    $view['states'] = $states;
    $view['state_count'] = count($states);
    $view['total'] = number_format($map['total']);
    $view['date'] = $map['date'];
    $image = $map['image'] . '?bust=' . $map['total'];
    if (strpos($image, '/var/tmp') === 0) {
        $image = substr($image, 8);
    }
    $view['image'] = $image;
}
thr_header('map-page');
echo template_render('whereAreReaders', $view);
thr_footer();
?>
