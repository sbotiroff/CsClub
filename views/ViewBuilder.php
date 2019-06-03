<?php

function returnViewPage($data)
{
    $page = $data["page"];
    $title = $data["title"];
    $status =$data['status'];
    $payload = $data["payload"];


    include APP_PATH . "/views/pages/$page.php";
}