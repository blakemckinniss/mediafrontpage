<?php
require_once "config.php";

$COMM_ERROR = "\n<p><strong>XBMC's JSON API did not respond.</strong></p>\n<p>Check your configuration (config.php) and that the JSON service variable is configured correctly and that the <a href=\"".$xbmcjsonservice."\">Service</a> is running.</p>\n";
$JSON_ERROR = "\n<p><strong>XBMC's <a href=\"".$xbmcjsonservice."\">JSON API service</a> returned an Error.</strong></p>\n";
$videodetailfields = '"genre", "director", "trailer", "tagline", "plot", "plotoutline", "title", "originaltitle", "lastplayed", "showtitle", "firstaired", "duration", "season", "episode", "runtime", "year", "playcount", "rating", "writer", "studio", "mpaa", "premiered", "album"';

$xbmcJsonMethods = array(
		'JSONRPC.Version' => array(
			'call' => '{"jsonrpc": "2.0", "method": "JSONRPC.Version", "id": 1}'
		),
		'JSONRPC.Introspect' => array(
			'call' => '{"jsonrpc": "2.0", "method": "JSONRPC.Introspect", "id": 1}'
		),
		'JSONRPC.Permission' => array(
			'call' => '{"jsonrpc": "2.0", "method": "JSONRPC.Permission", "id": 1}'
		),
		'JSONRPC.Ping' => array(
			'call' => '{"jsonrpc": "2.0", "method": "JSONRPC.Ping", "id": 1}'
		),
		'AudioLibrary.GetArtists' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioLibrary.GetArtists", "params": { "sortmethod": "artist", "sortorder" : "ascending" , "fields": [ "artist", "year" ]}, "id": 1}'
		),
		'AudioLibrary.GetAlbums' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioLibrary.GetAlbums", "params": { %s "sortmethod": "artist", "sortorder" : "ascending", "fields": [ "artist", "year" ] },"id": 1}',
			'args' => array(
				'artistid' => ''
			),
			'optional' => array(
				'artistid' => '"artistid": 1,'
			)
		),
		'AudioLibrary.GetSongs' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioLibrary.GetSongs", "params": { %s %s "fields": [ "artist", "year" ] },"id": 1}',
			'args' => array(
				'artistid' => '',
				'albumid' => ''
			)
		),
		'AudioPlayer.PlayPause' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.PlayPause", "id": 1}'
		),
		'AudioPlayer.Stop' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.Stop", "id": 1}'
		),
		'AudioPlayer.SkipPrevious' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.SkipPrevious", "id": 1}'
		),
		'AudioPlayer.SkipNext' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.SkipNext", "id": 1}'
		),
		'AudioPlayer.BigSkipBackward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.BigSkipBackward", "id": 1}'
		),
		'AudioPlayer.BigSkipForward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.BigSkipForward", "id": 1}'
		),
		'AudioPlayer.SmallSkipBackward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.SmallSkipBackward", "id": 1}'
		),
		'AudioPlayer.SmallSkipForward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.SmallSkipForward", "id": 1}'
		),
		'AudioPlayer.Rewind' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.Rewind", "id": 1}'
		),
		'AudioPlayer.Forward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.Forward", "id": 1}'
		),
		'AudioPlayer.GetPercentage' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.GetPercentage", "id": 1}'
		),
		'AudioPlayer.GetTime' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlayer.GetTime", "id": 1}'
		),
		'AudioPlaylist.Add' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlaylist.Add", "params": { "songid" : %d }, "id": 1}',
			'args' => '0'
		),
		'AudioPlaylist.GetItems' => array(
			'call' => '{"jsonrpc": "2.0", "method": "AudioPlaylist.GetItems", "params": { "fields": ["title", "album", "artist", "duration"] }, "id": 1}'
		),
		'Files.GetSources' => array(
			'call' => '{"jsonrpc": "2.0", "method": "Files.GetSources", "params" : { "media" : "%s" }, "id": 1}',
			'args' => 'music'
		),
		'Files.Download' => array(
			'call' => '{"jsonrpc": "2.0", "method": "Files.Download", "params": %s, "id": 1}',
			'args' => '""'
		),
		'Player.GetActivePlayers' => array(
			'call' => '{"jsonrpc": "2.0", "method": "Player.GetActivePlayers", "id": 1}'
		),
		'Playlist.GetItems' => array(
			'call' => '{"jsonrpc": "2.0", "method": "Playlist.GetItems", "id": 1}'
		),
		'VideoLibrary.GetRecentlyAddedMovies' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoLibrary.GetRecentlyAddedMovies", "params" : { "start" : 0 , "end" : %d , "fields": [ "genre", "director", "trailer", "tagline", "plot", "plotoutline", "title", "originaltitle", "lastplayed", "showtitle", "firstaired", "duration", "season", "episode", "runtime", "year", "playcount", "rating", "writer", "studio", "mpaa", "premiered", "album" ] }, "id" : 1 }',
			'sql' => array(
				'db' => 'MyVideos34.db',
				'query' => 'select * from movieview  order by idMovie desc limit %d'
			),
			'args' => 50
		),
		'VideoLibrary.GetMovies' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoLibrary.GetMovies", "params": { "sortorder" : "ascending", "fields" : [ "genre", "director", "trailer", "tagline", "plot", "plotoutline", "title", "originaltitle", "lastplayed", "showtitle", "firstaired", "duration", "season", "episode", "runtime", "year", "playcount", "rating", "writer", "studio", "mpaa", "premiered", "album" ] }, "id": 1}'
		),
		'VideoLibrary.GetRecentlyAddedEpisodes' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoLibrary.GetRecentlyAddedEpisodes", "params" : { "start" : 0 , "end" : %d , "fields": [ "genre", "director", "trailer", "tagline", "plot", "plotoutline", "title", "originaltitle", "lastplayed", "showtitle", "firstaired", "duration", "season", "episode", "runtime", "year", "playcount", "rating", "writer", "studio", "mpaa", "premiered", "album" ] }, "id" : 1 }',
			'args' => 50
		),
		'VideoLibrary.GetTVShows' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoLibrary.GetTVShows", "id" : 1 }'
		),
		'VideoLibrary.GetEpisodes' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoLibrary.GetEpisodes", "params" : { "tvshowid" : %d, "season" : %d, "fields": [ "genre", "director", "trailer", "tagline", "plot", "plotoutline", "title", "originaltitle", "lastplayed", "showtitle", "firstaired", "duration", "season", "episode", "runtime", "year", "playcount", "rating", "writer", "studio", "mpaa", "premiered", "album" ] }, "id" : 1 }',
			'args' => array(
				'tvshowid' => 1,
				'season' => 1
			)
		),
		'VideoLibrary.GetSeasons' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoLibrary.GetSeasons", "params" : { "tvshowid" : %d, "fields": [ "genre", "title", "showtitle", "duration", "season", "episode", "year", "playcount", "rating", "studio", "mpaa" ] }, "id" : 1 }',
			'args' => array(
				'tvshowid' => 1
			)
		),
		'VideoLibrary.ScanForContent' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoLibrary.ScanForContent", "id" : 1 }'
		),
		'VideoPlayer.PlayPause' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.PlayPause", "id": 1}'
		),
		'VideoPlayer.Stop' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.Stop", "id": 1}'
		),
		'VideoPlayer.SkipPrevious' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.SkipPrevious", "id": 1}'
		),
		'VideoPlayer.SkipNext' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.SkipNext", "id": 1}'
		),
		'VideoPlayer.BigSkipBackward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.BigSkipBackward", "id": 1}'
		),
		'VideoPlayer.BigSkipForward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.BigSkipForward", "id": 1}'
		),
		'VideoPlayer.SmallSkipBackward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.SmallSkipBackward", "id": 1}'
		),
		'VideoPlayer.SmallSkipForward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.SmallSkipForward", "id": 1}'
		),
		'VideoPlayer.Rewind' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.Rewind", "id": 1}'
		),
		'VideoPlayer.Forward' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.Forward", "id": 1}'
		),
		'VideoPlayer.GetPercentage' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.GetPercentage", "id": 1}'
		),
		'VideoPlayer.GetTime' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlayer.GetTime", "id": 1}'
		),
		'VideoPlaylist.GetItems' => array(
			'call' => '{"jsonrpc": "2.0", "method": "VideoPlaylist.GetItems", "params": { "fields": ["title", "season", "episode", "plot", "duration", "showtitle"] }, "id": 1}'
		),
		'System.GetInfoLabels' => array(
			'call' => '{"jsonrpc": "2.0", "method": "System.GetInfoLabels", "params": ["%s"], "id": 1}',
			'args' => 'System.ProfileName'
		),
		'System.Shutdown' => array(
			'call' => '{"jsonrpc": "2.0", "method": "System.Shutdown", "id" : 1 }'
		),
		'XBMC.Play' => array(
			'call' => '{"jsonrpc": "2.0", "method": "XBMC.Play", "params": { %s }, "id": 1}',
			'optional' => array(
				'songid' => '"songid": 1',
				'file' => '"file": "path_to_file"'
			)
		)
	);
	
function msprintf($format, $args) {
	if(is_array($args)) {
		return vsprintf($format, $args);
	} else {
		return sprintf($format, $args);
	}
}

function jsonstring($method, $args = array()) {
	global $xbmcJsonMethods;
	
	if(!empty($xbmcJsonMethods[$method])) {
		if(!empty($args)) {
			return msprintf($xbmcJsonMethods[$method]['call'], $args);
		} else {
			if(!empty($xbmcJsonMethods[$method]['args'])) {
				return msprintf($xbmcJsonMethods[$method]['call'], $xbmcJsonMethods[$method]['args']);
			} else {
				return $xbmcJsonMethods[$method]['call'];
			}
		}
	} else {
		return false;
	}
}
function jsonmethodcall($method, $args = array(), $service_uri = "") {
	$request = jsonstring($method, $args);
	return jsoncall($request, $service_uri);
}
function jsoncall($request, $service_uri = "") {
	global $xbmcjsonservice;
	global $DEBUG;
	global $JSON_ERROR;
	global $COMM_ERROR;
	global $FORCE_UTF8;
	
	if($service_uri == "") {
		$service_uri = $xbmcjsonservice;
	}

	//json rpc call procedure
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_URL, $service_uri);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	$response = curl_exec($ch);
	curl_close($ch);

	if(!empty($FORCE_UTF8) && $FORCE_UTF8) {
		$response = jsonFixEncoding($response);
	}
	
	$arrResult = json_decode($response, true);
	if((!empty($arrResult['error'])) && (!empty($DEBUG) && $DEBUG)) {
		echo $JSON_ERROR;
		echo "<p><strong>Last JSON Error: ".json_last_error()."</strong></p>\n";
		echo "<p><strong>Request:</strong><pre>$request</pre></p>\n";
		echo "<p><strong>Response:</strong><pre>$response</pre></p>\n";
	}
	if((empty($arrResult)) && (!empty($DEBUG) && $DEBUG)) {
		echo $COMM_ERROR;
		echo "<p><strong>".jsonerrorstring(json_last_error())."</strong></p>\n";
		echo "<p><strong>Request:</strong><pre>$request</pre></p>\n";
		echo "<p><strong>Response:</strong><pre>$response</pre></p>\n";
	}
	return $arrResult;
}
function jsonerrorstring($err) {
	switch($err) {
		case JSON_ERROR_DEPTH:
			$error =  ' - Maximum stack depth exceeded';
			break;
		case JSON_ERROR_CTRL_CHAR:
			$error = ' - Unexpected control character found';
			break;
		case JSON_ERROR_SYNTAX:
			$error = ' - Syntax error, malformed JSON';
			break;
		case JSON_ERROR_STATE_MISMATCH:
			$error = ' - Syntax error, Invalid or malformed JSON';
			break;
		//case JSON_ERROR_UTF8:
		//	$error = ' - Malformed UTF-8 characters, possibly incorrectly encoded';
		//	break;
		case JSON_ERROR_NONE:
			$error = '';                    
		default:
			$error = ' Error #'.$err;                    
	}
	if (!empty($error)) {
	//	throw new Exception('JSON Error: '.$error);        
		return "JSON Error: ".$error;
    }
}

function jsonFixEncoding($s){ 
    if(empty($s)) {
		return $s; 
	} else {
		$s = preg_match_all("#[\x09\x0A\x0D\x20-\x7E]|[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]#x", $s, $m );
		return implode("",$m[0]); 
	}
}

function sqlquerystring($method, $args = array()) {
	global $xbmcJsonMethods;
	
	if(!empty($xbmcJsonMethods[$method]['sql'])) {
		if(!empty($args)) {
			return msprintf($xbmcJsonMethods[$method]['sql']['query'], $args);
		} else {
			if(!empty($xbmcJsonMethods[$method]['args'])) {
				return msprintf($xbmcJsonMethods[$method]['sql']['query'], $xbmcJsonMethods[$method]['args']);
			} else {
				return $xbmcJsonMethods[$method]['sql']['query'];
			}
		}
	} else {
		return false;
	}
}
function sqlitetoarray($sql, $dbname) {
	global $xbmcdbpath;

	if ($dbhandle = new PDO($xbmcdbpath.$dbname)) { 
		$dbquery = @$dbhandle->query($sql);
		if ($dbquery === false) {
			$dbhandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$error = $dbhandle->errorInfo();
			if($error[0] != "") {
				$errCode = (-1 * $error[1]) - 41000;
				$errMsg = 'Datbase Query Error:'.$error[2];
			} else {
				$errCode = -41000;
				$errMsg = 'Datbase Query Error';
			}
			$return = array('error' => array('code' => $errCode, 'message' => $errMsg), 'id' => 0, 'jsonrpc' => '2.0');
		} else {
			$results = $dbquery->fetchAll();
			$return = array('id' => 1, 'jsonrpc' => '2.0', 'result' => array('start' => 0, 'end' => sizeof($results), 'movies' => $results ), 'total' => sizeof($results));
		}
	} else {
		$dbhandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$error = $dbhandle->errorInfo();
		if($error[0] != "") {
			$errCode = (-1 * $error[1]) - 40000;
			$errMsg = 'Datbase Connection Error:'.$error[2].' ('.$xbmcdbpath.$dbname.')';
		} else {
			$errCode = -40000;
			$errMsg = 'Datbase Connection Error: ('.$xbmcdbpath.$dbname.')';
		}
		$return = array('error' => array('code' => $errCode, 'message' => $errMsg), 'id' => 0, 'jsonrpc' => '2.0');
	}
	return $return;
}
?>
<?php
if(!empty($_REQUEST['tester']) && $_REQUEST['tester']='y') {
	if(!empty($_POST['request'])) {
		$request = str_replace('\"', '"', $_POST['request']);
	} else {
		$request = "";
	}
	if(!empty($_POST['query'])) {
		$query = str_replace('\"', '"', $_POST['query']);
	} else {
		$query = "";
	}
	if(!empty($_POST['dbname'])) {
		$dbname = str_replace('\"', '"', $_POST['dbname']);
	} else {
		//$dbname = "MyVideos34.db";
		$dbname = "";
	}
?>
<html>
	<head>
		<title>XBMC JSON Tester</title>
		<script type="text/javascript" language="javascript">
		<!--
			function setRequest(lstCalls) {
				var txtRequest = document.getElementById("txtRequest");
				txtRequest.value = lstCalls.value;
			}
			function setQuery(lstCalls) {
				var txtQuery = document.getElementById("txtQuery");
				txtQuery.value = lstCalls.value;
				var txtDB = document.getElementById("txtDB");
				txtDB.value = lstCalls.options[lstCalls.selectedIndex].label;
			}
		-->
		</script>
	</head>
	<body>
		<div id="form">
			<form action="" method="post">
				<input type="hidden" name="tester" value="yes"/>
				<select onchange="setRequest(this);">
					<option value="">[Predefined Queries]</option>
					<!--
					// Video Details: 
					// "genre", "director", "trailer", "tagline", "plot", "plotoutline", "title", "originaltitle", "lastplayed", "showtitle", "firstaired", "duration", "season", "episode", "runtime", "year", "playcount", "rating", "writer", "studio", "mpaa", "premiered", "album" 

					// Music Details:
					// "title", "album", "artist", "albumartist", "genre", "tracknumber", "discnumber", "trackanddiscnumber", "duration", "year", "musicbrainztrackid", "musicbrainzartistid", "musicbrainzalbumid", "musicbrainzalbumartistid", "musicbrainztrmidid", "comment", "lyrics", "rating"
					-->
<?php
					foreach($xbmcJsonMethods as $method => $arrmethod) {
						echo "<option value='".jsonstring($method)."'>".$method."</option>\n";
						if(!empty($arrmethod['optional'])) {
							foreach($arrmethod['optional'] as $key => $option) {
								echo "<option value='".jsonstring($method, $option)."'>".$method." (".$key.")</option>\n";
							}
						}
					}
?>
				</select>
				<input id="txtRequest" name="request" type="text" size="100" value='<?php echo $request; ?>' />
				<input type="submit" value="Submit" /><br/><br/>
				<select onchange="setQuery(this);">
					<option value="">[Predefined Queries]</option>
					<!--
					// Video Details: 
					// "genre", "director", "trailer", "tagline", "plot", "plotoutline", "title", "originaltitle", "lastplayed", "showtitle", "firstaired", "duration", "season", "episode", "runtime", "year", "playcount", "rating", "writer", "studio", "mpaa", "premiered", "album" 

					// Music Details:
					// "title", "album", "artist", "albumartist", "genre", "tracknumber", "discnumber", "trackanddiscnumber", "duration", "year", "musicbrainztrackid", "musicbrainzartistid", "musicbrainzalbumid", "musicbrainzalbumartistid", "musicbrainztrmidid", "comment", "lyrics", "rating"
					-->
<?php
					foreach($xbmcJsonMethods as $method => $arrmethod) {
						if(!empty($arrmethod['sql'])) {
							echo "<option value='".sqlquerystring($method)."' label='".$arrmethod['sql']['db']."'>".$method."</option>\n";
						}
					}
?>
				</select>
				<input id="txtDB" name="dbname" type="text" size="25" value='<?php echo $dbname; ?>' />
				<input id="txtQuery" name="query" type="text" size="100" value='<?php echo $query; ?>' />
			</form>
		</div>
		<div id="query">
<?php
			if(!empty($_POST['request'])) {
				$result = jsoncall($request);

				echo "<br/>Call: <pre>";
				echo print_r($request,1);   // debugging
				echo "</pre><br/>";
				echo "<br/>Result: <pre>";
				echo print_r($result,1); // debugging
				echo "</pre><br/>";
			}
			if(!empty($_POST['query']) && !empty($_POST['dbname'])) {
				//$method = 'VideoLibrary.GetRecentlyAddedMovies';
				//$result = sqlitetoarray(sqlquerystring($method , 25), $xbmcJsonMethods[$method]['sql']['db']);
				$result = sqlitetoarray($query, $dbname);

				echo "<br/>Call: <pre>";
				echo print_r($query,1);   // debugging
				echo "</pre><br/>";
				echo "<br/>Result: <pre>";
				echo print_r($result,1); // debugging
				echo "</pre><br/>";
			}
?>
		</div>
	</body>
</html>
<?php
}
?>