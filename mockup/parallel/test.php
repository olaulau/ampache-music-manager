<?php

$nb_processes = 10;

// open ten processes
for ($j = 0; $j < $nb_processes; $j++) {
	$pipe[$j] = popen('./sleep.sh', 'w');
}

// wait for them to finish
for ($j = 0; $j < $nb_processes; ++$j) {
	pclose($pipe[$j]);
}
