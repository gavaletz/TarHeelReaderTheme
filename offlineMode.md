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
1. the "offline" button, a Cache Manifest file is dynamically generated, in which all of the favorited books' pages, and images are cached.
2. This Cache Manifest file is then set to the HTML element of the page's header (specified in header.php).
3. Following this, AppCache will cache all of the resources specified in the Cache Manifest file, and the user can safely go offline.

