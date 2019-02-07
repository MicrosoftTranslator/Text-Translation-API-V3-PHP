<?php
// NOTE: Be sure to uncomment the following line in your php.ini file.
// ;extension=php_openssl.dll

$host = "https://api.cognitive.microsofttranslator.com";
$path = "/languages?api-version=3.0";
$output_path = "output.txt";
function GetLanguages ($host, $path) {
    $headers = "Content-type: text/xml\r\n";
    // NOTE: Use the key 'http' even if you are making an HTTPS request. See:
    // http://php.net/manual/en/function.stream-context-create.php
    $options = array (
        'http' => array (
            'header' => $headers,
            'method' => 'GET'
        )
    );
    $context  = stream_context_create ($options);
    $result = file_get_contents ($host . $path, false, $context);
    return $result;
}
$result = GetLanguages ($host, $path);
// Note: We convert result, which is JSON, to and from an object so we can pretty-print it.
// We want to avoid escaping any Unicode characters that result contains. See:
// http://php.net/manual/en/function.json-encode.php
$json = json_encode(json_decode($result), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
// Write the output to file.
$out = fopen($output_path, 'w');
fwrite($out, $json);
fclose($out);
?>
