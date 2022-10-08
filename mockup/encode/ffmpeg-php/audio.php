<?php
require_once './vendor/autoload.php';

use Char0n\FFMpegPHP\Movie;
use Char0n\FFMpegPHP\OutputProviders\FFMpegProvider;

$audio = new Movie('../audio.flac');
$out = new FFMpegProvider();
$audio->setProvider($out);
$out->setMovieFile("audio.m4a");

// impossible to encode ?
