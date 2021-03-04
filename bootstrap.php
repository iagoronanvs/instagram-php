<?php

require __DIR__ . '/vendor/autoload.php';

$profile = new Iagoronanvs\Instagram("apple");

print_r($profile->feed());