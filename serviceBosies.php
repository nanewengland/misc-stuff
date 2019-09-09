<?php

$serviceBodies = json_decode(file_get_contents("https://www.nerna.org/main_server/client_interface/json/?switcher=GetServiceBodies"), true);

$output = array();

foreach ($serviceBodies as &$serviceBody) {
    if ($serviceBody['id'] != '16' && $serviceBody['id'] != '17' && $serviceBody['id'] != '18') {
        $serviceBody['helpline'] = '866-624-3578';
    }
    if ($serviceBody['id'] == '8') {
        $serviceBody['helpline'] = '866-686-2669';
    }
    if ($serviceBody['id'] != '16' && $serviceBody['id'] != '17' && $serviceBody['id'] != '18') {
        $output[] = $serviceBody;
    }

}

usort($output, function ($a, $b) {
    return strnatcasecmp($a['name'], $b['name']);
});

header('Content-type: application/json');

echo json_encode($output);

