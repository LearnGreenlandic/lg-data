<?php

chdir(__DIR__);

// Change filename and [0] as needed

foreach (['3x/vi-3sg.txt'] as $f) {
	$fs = explode("\n", trim(file_get_contents($f)));
	foreach ($fs as $s) {
		$s = explode("\t", $s)[1];
		if (file_exists("mp3/{$s}.mp3") && filesize("mp3/{$s}.mp3")) {
			echo "Existed: $s\n";
			continue;
		}

		$html = file_get_contents('https://oqaasileriffik.gl/en/langtech/martha/?st='.urlencode($s));
		if (preg_match('~(/d/martha/.*?mp3)~', $html, $m)) {
			$mp3 = file_get_contents('https://oqaasileriffik.gl'.$m[1]);
			file_put_contents("mp3/{$s}.mp3", $mp3);
			echo "Downloaded: $s\n";
		}
		else {
			echo "Failed: $s\n";
		}
	}
}
