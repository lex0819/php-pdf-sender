<?php

$userName = 'lex';
$userDate = date('m/d/Y H:i:s', 1709312209);
$userText = 'hi bot';
$currentDate = date("D M j G:i:s T Y");

$text = "Hi {$userName}! \r\n You wrote {$userText} to me \r\n at {$userDate}. I'm very glad to see you. \r\n Now {$currentDate}";

var_dump($text);
