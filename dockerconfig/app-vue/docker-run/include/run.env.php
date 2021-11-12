<?php

$filename = "/usr/src/app/src/main.js";
$base_source = file_get_contents($filename);


$vue_api_url = getenv('VUE_API_URL');

$repWith = "\n";
$repWith .= "app.config.globalProperties.\$apibase = \"$vue_api_url\";\n";

$pattern =
  '/(\/\*\*\ ENV\-CODE\-START\ \*\*\/)\K' .
  '(.*(\r*\n))' .
  '*?(?=\/\*\*\ ENV\-CODE\-END\ \*\*\/)/';


echo "\n\n----------------------------------------------------------------------\n";

$newFile = preg_replace($pattern, $repWith, $base_source);

echo "Adding ENV rows: $repWith";

file_put_contents($filename, $newFile);

echo "\n\n----------------------------------------------------------------------\n";
