<?php

$ajResult = json_decode('[]');

$sajMeeps = json_encode( $ajResult , JSON_UNESCAPED_UNICODE );
echo $sajMeeps;
?>