<?

$host = "http://www.baidu.com";
$path = $_SERVER['REQUEST_URI'];
$url = $host.$path;

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $HTML = sendRequest($url,'GET',null);
        break;
    case "POST":
        switch($_SERVER['CONTENT_TYPE']) {
            case 'application/x-www-form-urlencoded':
                $HTML = sendRequest($url,'POST');
                break;        
            //暂不考虑其他数据上传的情况
        }
    default:
        exit;
}
echo $HTML;

function sendRequest($url,$type){
    $curlHanddle = curl_init();
    if($type == 'POST'){
        //如果是post请求，则设置相关post参数和传递数据
        curl_setopt($curlHanddle, CURLOPT_POST,true);
        $strPOST = json_encode($_POST);
        curl_setopt($curlHanddle, CURLOPT_POSTFIELDS,$strPOST);
    }

    curl_setopt($curlHanddle, CURLOPT_URL, $url);
    curl_setopt($curlHanddle, CURLOPT_RETURNTRANSFER, 1 );
    $resultContent = curl_exec($curlHanddle);
    $resultStatus = curl_getinfo($curlHanddle);
    curl_close($curlHanddle);
    if(intval($resultStatus["http_code"])==200){
        return $resultContent;
    }else{
        return false;
    }
}