<?php
ob_start();

$strNo = rand(1, 1000000);

date_default_timezone_set('Asia/Calcutta');

//echo date_default_timezone_get();

$strCurDate = date('d-m-Y');

//require_once 'TransactionRequestBean.php';
//require_once 'TransactionResponseBean.php';
//session_start();

if ($_POST && isset($_POST['submit'])) {

    $val = $_POST;

    $_SESSION['iv'] = $val['iv'];
    $_SESSION['key'] = $val['key'];

    $transactionRequestBean = new TransactionRequestBean();

    //Setting all values here
    $transactionRequestBean->setMerchantCode($val['mrctCode']);
    $transactionRequestBean->setAccountNo($val['tpvAccntNo']);
    $transactionRequestBean->setITC($val['itc']);
    $transactionRequestBean->setMobileNumber($val['mobNo']);
    $transactionRequestBean->setCustomerName($val['custname']);
    $transactionRequestBean->setRequestType($val['reqType']);
    $transactionRequestBean->setMerchantTxnRefNumber($val['mrctTxtID']);
    $transactionRequestBean->setAmount($val['amount']);
    $transactionRequestBean->setCurrencyCode($val['currencyType']);
    $transactionRequestBean->setReturnURL($val['returnURL']);
    $transactionRequestBean->setS2SReturnURL($val['s2SReturnURL']);
    $transactionRequestBean->setShoppingCartDetails($val['reqDetail']);
    $transactionRequestBean->setTxnDate($val['txnDate']);
    $transactionRequestBean->setBankCode($val['bankCode']);
    $transactionRequestBean->setTPSLTxnID($val['tpsl_txn_id']);
    $transactionRequestBean->setCustId($val['custID']);
    $transactionRequestBean->setCardId($val['cardID']);
    $transactionRequestBean->setKey($val['key']);
    $transactionRequestBean->setIv($val['iv']);
    $transactionRequestBean->setWebServiceLocator($val['locatorURL']);
    $transactionRequestBean->setMMID($val['mmid']);
    $transactionRequestBean->setOTP($val['otp']);
    $transactionRequestBean->setCardName($val['cardName']);
    $transactionRequestBean->setCardNo($val['cardNo']);
    $transactionRequestBean->setCardCVV($val['cardCVV']);
    $transactionRequestBean->setCardExpMM($val['cardExpMM']);
    $transactionRequestBean->setCardExpYY($val['cardExpYY']);
    $transactionRequestBean->setTimeOut($val['timeOut']);

    // $url = $transactionRequestBean->getTransactionToken();

    $responseDetails = $transactionRequestBean->getTransactionToken();
    $responseDetails = (array) $responseDetails;
    $response = $responseDetails[0];

    if (is_string($response) && preg_match('/^msg=/', $response)) {
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

        $response = $transactionResponseBean->getResponsePayload();
        echo "<pre>";
        echo 'first';
        //print_r($response);
        exit;
    } elseif (is_string($response) && preg_match('/^txn_status=/', $response)) {
        echo "<pre>";
        //print_r($response);
        echo 'second';
        exit;
    }

    echo "<script>window.location = '" . $response . "'</script>";
    ob_flush();
} else if ($_POST) {

    $response = $_POST;

    if (is_array($response)) {
        $str = $response['msg'];
    } else if (is_string($response) && strstr($response, 'msg=')) {
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];
    } else {
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();

    $transactionResponseBean->setResponsePayload($str);
    $transactionResponseBean->setKey($_SESSION['key']);
    $transactionResponseBean->setIv($_SESSION['iv']);

    $response = $transactionResponseBean->getResponsePayload();
    echo "<pre>";
    //echo 'third';
    //print_r($response);
    $explode = explode('|', $response);
    print_r($explode);
    echo "<br><br><br><br>";
    
    print_r($_SESSION['cart']);
 unset($_SESSION['cart']);
    //session_destroy();
    ?>

    <a href='<?php echo base_url('items/dashboard'); ?>'>GO TO HOME</a>

    <?php
    exit;
}
?>

