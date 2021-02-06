<?php
$metatitle = "Joke Engine";
$h1title = "Joke Engine";
$apis = array(
  0 => "Internet Chuck Norris",
  1 => "JokeAPI",
  2 => "Official Joke API",
  3 => " - Not Valid JSON",
  4 => " - Domain Expired"
);
$optionsQty = '';
$optionsApi = '';
for ($i = 0; $i < 20; $i++) {
  $optionsQty .= '<option>'.($i+1).'</option>';
}
for ($i = 0; $i < count($apis); $i++) {
  $optionsApi .= '<option value="'.$i.'">'.$apis[$i].'</option>';
}
$form = '<form action="/" v-cloak><p>I would like to see <select name="number" id="n">'.$optionsQty.'</select> joke{{s}} <span class="vis-sm"></span>from the <span class="vis-md"></span><select name="api" id="api">'.$optionsApi.'</select> <span class="vis-sm"></span>database <button id="go" type="button">please</button></form>';
$replaces = array(
  '{{ title }}' => $metatitle,
  '{{ pagetitle }}' => $h1title,
  '{{ form }}' => $form
);
$template = file_get_contents('template/theme.html');
foreach ($replaces as $k => $v) {
  $template = str_replace($k, $v, $template);
}
echo $template;
