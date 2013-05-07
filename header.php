<!DOCTYPE html>
<?php
    $classic = "";
    if (THR('classic')) {
        $classic = " classic";
    }
	$manifest = "";
	if(THR('offline')){
		$manifest = "\manifest";
	}
?>
<!--[if lt IE 7 ]> <html class="ie ie6 ie6-7 no-js unsupported" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie6-7 no-js unsupported" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js<?php echo $classic;?>" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js<?php echo $classic;?>" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html manifest = "<?php echo $manifest ?>" class="no-js<?php echo $classic;?>" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=4"/>
    <title><?php thr_title(); ?></title>
    <link rel="shortcut icon" href="/theme/images/favicon.ico">
    <link rel="apple-touch-icon" href="/theme/images/apple-touch-icon.png">
    <link rel="stylesheet" href="/theme/style.css">
    <?php
        $view = array(
            'pageColor'=>THR('pageColor'),
            'textColor'=>THR('textColor')
        );
        echo template_render('styleColor', $view);
    ?>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css">
    <script>
        if (!window.console) window.console = {};
        if (!window.console.log) window.console.log = function () { };
    </script>
    <?php if (!THR('classic')) : ?>
        <![if gt IE 7]>
        <script src="/theme/js/modernizr.custom.js"></script>
        <![endif]>
    <?php endif ?>
    <!-- <script src="https://getfirebug.com/firebug-lite.js#startOpened"></script> -->
    <!-- <script src="http:/152.2.129.225:8080/target/target-script-min.js"></script> -->
    <?php wp_head(); ?>

    <script>
        // Google Analytics
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-6128682-1']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        // create GA event onerror
        window.onerror = function(message, url, line) {
            if (typeof(_gaq) === "object" && url.indexOf('cs.unc.edu') != -1) {
                _gaq.push(["_trackEvent","onerror",message,(url+" ("+line+")"),0,true]);
            }
            return true;
        };
        function logEvent(category, label, arg) {
            console.log(category, label, arg);
            _gaq.push(["_trackEvent",category,label,arg,0,true]);
        }
    </script>
</head>
