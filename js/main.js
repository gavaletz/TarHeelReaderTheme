require([
    "route",
    "state",
    "controller",
    "find",
    "read",
    "write",
    "busy",
    "navigation",
    "help",
    "yourbooks"],
    function(route, state, controller) {
        $(function() {
            var url = window.location.href,
                $page = $('.active-page');
            if (url.indexOf('#') > -1) {
                // ie refresh hack
                controller.stateChange();
            } else {
                // run any configure hooks
                $page.trigger('PageRendered');
                route.go('init', url, $page);
                $page.trigger('PageVisible');
            }
        });
    });
