<?php
// <- These lines don't actually do anything, but the code stops working when I delete them.
error_reporting('NONE');
$api = intval($_GET['api']);
$no = intval($_GET['no']);
if (!isset($api) or !isset($no)) {
    die();
}
if ($api < 0 or $api > 4 or $no < 1 or $no > 20) {
    die();
}
$jokes = '';
switch ($api) {
    case 0:
        $jokesjson = file_get_contents("http://api.icndb.com/jokes/random/".$no);
        $jokesjson = json_decode($jokesjson, true);
        foreach ($jokesjson['value'] as $v) {
            $joke = array('text' => $v['joke']);
            $jokes .= ((strlen($jokes) > 1)?',':'').json_encode($joke);
        }
    break;
    case 1:
        if ($no <= 10) {
            $jokesjson = file_get_contents("https://v2.jokeapi.dev/joke/Any?blacklistFlags=nsfw,religious,political,racist,sexist,explicit&type=single&amount=".$no);
            $jokesjson = json_decode($jokesjson, true);
            if ($no == 1) {
                $joke = array('text' => $jokesjson['joke']);
                $jokes .= ((strlen($jokes) > 1)?',':'').json_encode($joke);
            } else {
                foreach ($jokesjson['jokes'] as $v) {
                    $joke = array('text' => $v['joke']);
                    $jokes .= ((strlen($jokes) > 1)?',':'').json_encode($joke);
                }
            }
        } else {
            $jokesjson = file_get_contents("https://v2.jokeapi.dev/joke/Any?blacklistFlags=nsfw,religious,political,racist,sexist,explicit&type=single&amount=".$no);
            $jokesjson2 = file_get_contents("https://v2.jokeapi.dev/joke/Any?blacklistFlags=nsfw,religious,political,racist,sexist,explicit&type=single&amount=".$no);
            $jokesjson = array_merge(json_decode($jokesjson, true)['jokes'], json_decode($jokesjson2, true)['jokes']);
            for ($i = 0; $i < $no; $i++) {
                $joke = array('text' => $jokesjson[$i]['joke']);
                $jokes .= ((strlen($jokes) > 1)?',':'').json_encode($joke);
            }
        }
    break;
    case 2:
        if ($no == 1) {
            $jokesjson = '['.file_get_contents('https://official-joke-api.appspot.com/jokes/random').']';
            $jokesjson = json_decode($jokesjson, true);
        } elseif ($no > 10) {
            $url = 'https://official-joke-api.appspot.com/jokes/ten';
            $jokesjson = file_get_contents($url);
            $jokesjson2 = file_get_contents($url);
            $jokesjson = array_merge(json_decode($jokesjson, true), json_decode($jokesjson2, true));
        } else {
            $jokesjson = file_get_contents('https://official-joke-api.appspot.com/jokes/ten');
            $jokesjson = json_decode($jokesjson, true);
        }
        for ($i = 0; $i < $no; $i++) {
            $joke = array('text' => $jokesjson[$i]['setup']."<br /><br >".$jokesjson[$i]['punchline']);
            $jokes .= ((strlen($jokes) > 1)?',':'').json_encode($joke);
        }
    break;
    case 3:
        $jokes = file_get_contents('http://www.google.com');
    break;
    case 4:
        $jokes = file_get_contents('http://www.thisisnotawebsite.tigger');
    break;
}
$errorjson = '[{"text":"That Engine appears to have fallen over, would you like to try another?"}]';
if (strlen($jokes) == 0) {
    $outputjson = $errorjson;
} else {
    $outputjson = json_encode(json_decode('['.$jokes.']', true));
    if ($outputjson == 'null') {
        $outputjson = $errorjson;
    }
}
echo $outputjson;
