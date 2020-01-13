<?php

$TOKEN = "YOUR_TOKEN";

// Android -> https://push-pole.com/docs/api/

$data = array(
    "app_ids" => ["YOUR_APP_ID",],
    "data" => array(
        "title" => "this is the title",
        "content" => "this is the content",

        //actions -> https://push-pole.com/docs/api/#api_action_type_table3
        "action" => array(
            "action_type" => "U",
            "url" => "myket://application/#Intent;scheme=myket;package=package_name",
        ),

        "buttons" => array(
            array(
                "btn_action" => array(
                    "action_data" => "ActivityName",
                    "action_type" => "T",
                    "market_package_name" => "",
                    "url" => "",
                ),
                "btn_content" => "content",
                // icons -> https://push-pole.com/docs/api/#api_icon_notificaiton_table2
                "btn_icon" => "open_in_browser",
                "btn_order" => 0,
            )
        ),
    ),
    // additional keywords -> https://push-pole.com/docs/api/#api_send_advance_notification
);


$ch = curl_init("https://api.push-pole.com/v2/messaging/notifications/");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Token " . $TOKEN,
));

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$reponse = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "status code => $status_code\n";
echo "response => $reponse\n";
echo "==========\n";

if ($status_code == 201) {
    echo "Success!\n";

    $reponse_json = json_decode($reponse);

    if ($reponse_json->hashed_id) {
        $report_url = "https://push-pole.com/report?id=$reponse_json->hashed_id";
    } else {
        $report_url = "no report url for your plan";
    }
    echo "report_url: $report_url\n";

    echo "notification id: $reponse_json->wrapper_id\n";
} else {
    echo "failed!\n";
}


?>
