<?php

$widgetMediaLibrary = array(
			'Id' 			=> "wMediaLibrary", 
			'Child'			=> "false",
			'Type' 			=> "ajax", 
			'Title' 		=> "Media Library", 
			'Parts'			=> "",
			'Stylesheet' 		=> "",
			'Section' 		=> 1, 
			'Position' 		=> 3,
			'Function' 		=> "",
			'HeaderFunction' 	=> "widgetMediaLibraryHeader();",
			'Block' 		=> "medialibrarywrapper",   
			'Call'			=> "widgets/xbmc/wXBMCLibrary.php?w=l&style=w&a=l",
			'Loader'		=> "",
			'Interval'		=> "0",
			'Script'		=> ""
		     );

$widgetRecentEpisodes = array(	
			'Id' 			=> "wRecentEpisodes", 
			'Child'			=> "false",
			'Type' 			=> "ajax", 
			'Title' 		=> "Recent Episodes", 
			'Parts'			=> "",
			'Stylesheet' 		=> "",
			'Section' 		=> 1, 
			'Position' 		=> 3,
			'Function' 		=> "",
			'HeaderFunction' 	=> "widgetMediaLibraryHeader();",
			'Block' 		=> "recentepisodeswrapper",   
			'Call'			=> "widgets/xbmc/wXBMCLibrary.php?w=l&style=w&a=re&c=15",
			'Loader'		=> "",
			'Interval'		=> "60000",
			'Script'		=> ""
		     );

$widgetRecentMovies = array(	
			'Id' 			=> "wRecentMovies", 
			'Child'			=> "false",
			'Type' 			=> "ajax", 
			'Title' 		=> "Recent Movies", 
			'Parts'			=> "",
			'Stylesheet' 		=> "",
			'Section' 		=> 1, 
			'Position' 		=> 3,
			'Function' 		=> "",
			'HeaderFunction' 	=> "widgetMediaLibraryHeader();",
			'Block' 		=> "recentmovieswrapper",   
			'Call'			=> "widgets/xbmc/wXBMCLibrary.php?w=rm&style=w&a=rm&c=15",
			'Loader'		=> "",
			'Interval'		=> "60000",
			'Script'		=> ""
		     );

$widget_init = array(	'Id' 			=> "", 
			'Child'			=> "false",
			'Type' 			=> "empty", 
			'Title' 		=> "", 
			'Parts'			=> array($widgetMediaLibrary,$widgetRecentEpisodes,$widgetRecentMovies),
			'Stylesheet' 		=> "",
			'Section' 		=> 1, 
			'Position' 		=> 3,
			'Function' 		=> "",
			'HeaderFunction' 	=> "",
			'Block' 		=> "",   
			'Call'			=> "",
			'Loader'		=> "",
			'Interval'		=> "",
			'Script'		=> ""
		     );

function widgetMediaLibraryHeader($params = array('count' => 15)) {
	//check the parameter
	echo <<< LIBRARYHEADER
		<script type="text/javascript" language="javascript">
		<!--
			function cmdXbmcLibrary(wrapper, harness, action, breadcrumb, query, refresh) {
				var cmdXbmcLibraryRequest = new ajaxRequest();
				var request = harness+"style=w&a="+action+"&bc="+breadcrumb+query;
				cmdXbmcLibraryRequest.open("GET", request, true);

				if(action!="p") {
					cmdXbmcLibraryRequest.onreadystatechange = function() {
						if (cmdXbmcLibraryRequest.readyState==4) {
							if (cmdXbmcLibraryRequest.status==200 || window.location.href.indexOf("http")==-1) {
								document.getElementById(wrapper).innerHTML=cmdXbmcLibraryRequest.responseText;
							} else {
								//alert("An error has occured making the request (XbmcLibrary)");
							}
						}
					}
				}
				cmdXbmcLibraryRequest.send(null);
				if(refresh) {
					var cmd = "cmdXbmcLibrary('" + wrapper + "', '" + harness + "', '" + action + "', '" + breadcrumb + "', '" + query + "', true)";
					if(action=="rm" && recentmoviewrapper_interval=="") {
						recentmoviewrapper_interval = setInterval(cmd, 60000);
					}
					if(action=="re" && recentepisodeswrapper_interval=="") {
						recentepisodeswrapper_interval = setInterval(cmd, 60000);
					}
					if(action=="d") {
						if(breadcrumb == "rm") {
							//alert("bc="+breadcrumb);
							clearInterval(recentmoviewrapper_interval);
							recentmoviewrapper_interval = "";
						}
						if(breadcrumb == "re") {
							clearInterval(recentepisodeswrapper_interval);
							recentepisodeswrapper_interval = "";
						}
					}
				}
			}
		-->
		</script>

LIBRARYHEADER;
}

if (!empty($_GET['style']) && (($_GET['style'] == "w") || ($_GET['style'] == "s"))) {
	require_once "../../config.php";
	require_once "../../functions.php";
	require_once "libXBMCLibrary.php";

	$action = $_GET['a'];
	$breadcrumb = (!empty($_GET['bc'])) ? $_GET['bc'] : "";

	$params = getParameters($_GET);

	if ($_GET['style'] == "w") {
		switch ($_GET['w']) {
			case "re": // Recent Episodes
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['wrapper'])) {
					$params['wrapper'] = $widgetRecentEpisodes['Block'];
				}
				$params['harness'] = "widgets/xbmc/wXBMCLibrary.php?w=re&";
				$params['refresh'] = true;
				break;
			case "rm":  // Recent Movies
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['wrapper'])) {
					$params['wrapper'] = $widgetRecentMovie['Block'];
				}
				$params['harness'] = "widgets/xbmc/wXBMCLibrary.php?w=rm&";
				$params['refresh'] = true;
				break;
			default:
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['href'])) {
					$params['wrapper'] = $widgetMediaLibrary['Block'];
				}
				$params['harness'] = "widgets/xbmc/wXBMCLibrary.php?w=l&";
		}
		$params['href'] = "#";
	} else {
		if(empty($params['href'])) {
			$params['href'] = "xbmc/wXBMCLibrary.php";
		}
	}
	
	executeVideo($_GET['style'], $action, $breadcrumb, $params);
}
?>
