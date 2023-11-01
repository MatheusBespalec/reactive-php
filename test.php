<?php

$stream = fopen("file1.txt", "r");

sleep(20);
fclose($stream);
