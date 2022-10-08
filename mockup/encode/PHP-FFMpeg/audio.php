<?php
require 'vendor/autoload.php';

$ffmpeg = FFMpeg\FFMpeg::create();

$audio = $ffmpeg->open("../audio.flac");

$codec = new FFMpeg\Format\Audio\Aac();
// $codec = new FFMpeg\Format\Audio\Mp3();
// $codec = new FFMpeg\Format\Audio\Vorbis();
$codec->setAudioKiloBitrate(256);
$codec->setAudioCodec("aac");
$audio->save($codec, "./audio.m4a");
// $audio->save($codec, "./audio.mp3");
// $audio->save($codec, "./audio.ogg");
