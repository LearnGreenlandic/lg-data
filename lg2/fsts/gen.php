#!/usr/bin/env php
<?php
// find . -type f -name '*.fst' -exec php gen.php '{}' \;

$B=basename($argv[1], '.fst');

echo "$B up\n";
$up = trim(shell_exec("foma -q -e 'load $B.fst' -e 'random-upper 5000' -e quit | awk '{print $2}' | sort | uniq"));
file_put_contents("$B.up", $up);

echo "$B down\n";
$down = trim(shell_exec("cat '$B.up' | flookup -i '$B.fst' | grep -vF '+?'"));
$down = explode("\n\n", $down);

$good = [];
foreach ($down as $d) {
	$d = trim($d);
	if (strpos($d, "\n") === false && strpos($d, "\t") !== false) {
		$d = explode("\t", $d);
		$good[] = $d[1]."\t".$d[0];
	}
}
file_put_contents("$B.txt", implode("\n", $good)."\n");
