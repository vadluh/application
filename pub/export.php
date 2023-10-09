<?php
$installedModules = get_loaded_extensions();

if (!in_array('SimpleXML', $installedModules)) {
    throw new \Exception('SimpleXML PHP module is not installed');
}

require('../Service/ApiConnector.php');
require('../Model/UserList.php');

$connector = new ApiConnector();
//TODO: choose one of variants in both files (index.php and export.php)
//    $apiData = $connector->receive();
//    $apiData = $connector->receiveByCurl();
$apiData = $connector->emulateReceive(rtrim(getcwd(), 'pub') . 'fixtures/data.json');
$userListModel = new UserList();
$users = $userListModel->prepareData($apiData);

// array to xml function
function arrayToXml($data, &$xml_data)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            if (is_numeric($key)) {
                $key = 'user';
            }
            $subnode = $xml_data->addChild($key);
            arrayToXml($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
}

$xmlData = new SimpleXMLElement('<?xml version="1.0"?><users></users>');

arrayToXml($users, $xmlData);

//saving generated xml file;
$directoryPath = getcwd() . '/exports/';
if (!file_exists($directoryPath)) {
    mkdir($directoryPath);
}


$result = $xmlData->asXML($directoryPath . '/users-' . time() . '.xml');
