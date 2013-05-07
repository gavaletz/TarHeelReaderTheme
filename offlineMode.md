Offline Mode Documentation
===========================

This document outlines the set up of the TarHeel Reader offline mode. The
offline mode uses HTML AppCache. Before going to into details, let's review
the important, and relevant details abotu AppCache:

AppCache:
----------------------------

AppCache requires a Cache Manifest file (file extension .appcache). Within
this file, we will explicity list resources that we wish to cache, specified 
under the "CACHE" section. In addition to this, we will also specify fallback
pages for when we are in offline mode, specified under the FALLBACk section. For
this project, these are the main sections required in our Cache Manifest file.

The Cache Manifest file itself should be specified in the <html> element of the
.html file you are caching from, as shown below:

    <html manifest = "test.appcache">
    .....
    </html>
