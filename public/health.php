<?php
// Health check for Railway
header('Content-Type: text/plain');
header('Cache-Control: no-cache');
http_response_code(200);
echo "OK";
?>
