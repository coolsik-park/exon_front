<?php
function get_config() {
  return array(
    "apiKey" => getEnv('SOLAPI_API_KEY'),
    "apiSecret" => getEnv('SOLAPI_API_SECRET'),
    "protocol" => "https",
    "domain" => "api.solapi.com",
    "prefix" => ""
  );
}