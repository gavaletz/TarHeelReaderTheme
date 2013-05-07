Offline Mode Documentation
===========================

This document outlines the set up of the TarHeel Reader offline mode. The
offline mode uses HTML AppCache. Before going to into details, let's review
the AppCache quickly.

AppCache
----------------------------

AppCache requires a Cache Manifest file (file extension .appcache). Within
this file, we will explicity list resources that we wish to cache, specified 
under the CACHE section. In addition to this, we will also specify fallback
pages for when we are in offline mode, specified under the FALLBACK section. For
this project, these are the main sections required in our Cache Manifest file.

The Cache Manifest file itself should be specified in the <html> element of the
.html file you are caching from, as shown below:

    <html manifest = "test.appcache">
    .....
    </html>

Note that the .appcache file should be served with the proper MIME type:

    text/cache-manifest

This concludes the basic setup for AppCache. Now, let's discuss how it is
implemented in TarHeel Reader.

AppCache in TarHeel Reader
-------------------------------
In TarHeel Reader, we wish to create an offline mode, where users can continue
to read all books that they have favorited. The overall flow works in the following 
manner: 

1. The user selects his/her favorite books.
2. The user enters "offline" mode using a button in the Settings menu
3. The user's favorited books are all cached.
4. Now the user can go offline, and continue to read the books.

To implement this, we have employed the following design:

1. When the User clicks the "offline" button, a Cache Manifest file is dynamically generated, in which all of the favorited books' pages, and images are cached.
2. This Cache Manifest file is then set to the HTML element of the page's header (specified in header.php).
3. Following this, AppCache will cache all of the resources specified in the Cache Manifest file, and the user can safely go offline.

Given this design, let us now review the details of the implementation:

manifest.php
-------------------------------
This is the script that will generate the Cache Manifest. Let us now review its important components:

First, the script must send a header with the correct MIME type:

    header('Content-Type: text/cache-manifest');

Followed by this, we next specify static resources, such as the favorites icon, the general CSS file
for TarHeel Reader, etc. Once we have done this, we are now ready to dynamically cache the pages and images
of the favorited books.  This is accomplished using the following loop:

    for($i=0; $i<$size; $i++)
    {
        $post = get_post($favorites[$i]);
    	$book = ParseBookPost($post);
    	echo "/book-as-json/?slug=".$book['slug']."\n";
    	$bookPages = $book['pages'];
    	$numPages = count($bookPages);
    	for($j = 0; $j <$numPages+1; $j++)
        {
    		$pageArray = $bookPages[$j];
    		echo pageLink($book['link'], $j+1)."\n";
    		echo $pageArray['url']."\n";
    	}
    }

Above, we are looping through each favorited book and echoing/printing important resources. For each page in a book, 
we are echoing the page itself, and the image associated with it.

After this, we have now completed caching the important resources. Next, let us set the fallback page for offline 
mode:

    echo "FALLBACK:\n";
    echo "/ ".$fav_url."\n";

As you can see, we have set the fallback for all pages (the "/" serves as a wildcard) to the favorites pages ($fav_url). 

Now, we have completed setting up manifest.php. Next we need to specify manifest.php in the <html> element of our pages.
However, we only wish to do this when the user enters offline mode. To accomplish this, let us create an offline state 
for the application. 

state.php
-------------------------------
In this file, we will create an offline state for the application. First, in the existing $THRDefault array, we have
added the an offline variable, and initially set its value to 0 (false).

    'offline' => 0

In the array THRPatterns, we use a regular expression to specify the legal values for the offline state. We only allow
0 and 1 (false and true).
    'offline' => '/[01]/'

Now, we have set up an offline state for the application. Now let us setup a way for the user to trigger a state change.
First, we need to create an offline button in settings.html.


settings.html
-------------------------------
    <li><span class = "offline">_(Offline)</span></li>

After this, we can handle a click to this button in navigation.js

navigation.js
-------------------------------
In the following function, we specify that when the offline button is clicked, the application should redirect
to the favorites page, and also add a "offline=1" parameter to the url. I will explain the latter change below.

    $body.on("click", ".active-page .mainSettings:visible .offline", function() {
    	var url = state.favoritesURL();
    	var offlineURL = url+"&offline=1";
        var id = $(this).attr('data-id');
        window.location.href = offlineURL;
    });

Now that we have

