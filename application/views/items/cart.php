<!doctype html>
<?php
ob_start();

$strNo = rand(1, 1000000);

date_default_timezone_set('Asia/Calcutta');

//echo date_default_timezone_get();

$strCurDate = date('d-m-Y');

//require_once '/TransactionRequestBean.php';
//require_once 'TransactionResponseBean.php';
//session_start();

if ($_POST && isset($_POST['submit'])) {

    $val = $_POST;

    $_SESSION['iv'] = $val['iv'];
    $_SESSION['key'] = $val['key'];

    $transactionRequestBean = new TransactionRequestBean();

    //Setting all values here
    $transactionRequestBean->setMerchantCode($val['mrctCode']);
    //$transactionRequestBean->setAccountNo($val['tpvAccntNo']);
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
    //$transactionRequestBean->setBankCode($val['bankCode']);
    $transactionRequestBean->setTPSLTxnID($val['tpsl_txn_id']);
    $transactionRequestBean->setCustId($val['custID']);
    //$transactionRequestBean->setCardId($val['cardID']);
    $transactionRequestBean->setKey($val['key']);
    $transactionRequestBean->setIv($val['iv']);
    $transactionRequestBean->setWebServiceLocator($val['locatorURL']);
//    $transactionRequestBean->setMMID($val['mmid']);
//    $transactionRequestBean->setOTP($val['otp']);
//    $transactionRequestBean->setCardName($val['cardName']);
//    $transactionRequestBean->setCardNo($val['cardNo']);
//    $transactionRequestBean->setCardCVV($val['cardCVV']);
//    $transactionRequestBean->setCardExpMM($val['cardExpMM']);
//    $transactionRequestBean->setCardExpYY($val['cardExpYY']);
//    $transactionRequestBean->setTimeOut($val['timeOut']);
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

    session_destroy();
    ?>

    <a href='<?php echo "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['SCRIPT_NAME']; ?>'>GO TO HOME</a>

    <?php
    exit;
}
?>

<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html">
        <title>Custom Shopping Cart</title>
        <meta name="author" content="Jake Rocheleau">
        <link rel="shortcut icon" href="http://spyrestudios.com/favicon.ico">
        <link rel="icon" href="http://spyrestudios.com/favicon.ico">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>assets/css/styles.css">
    </head>
    <?php
    $cart = $_SESSION['cart'];
//echo '<pre>';print_r($cart);
    ?>
    <body>
        <div id="w">
            <header id="title">
                <h1>HTML5/CSS3 Shopping Cart UI</h1>
            </header>
            <div><small>You have <em class="highlight"><?php echo count($cart); ?> item(s)</em> in your shopping bag</small></div>
            <div id="page">
                <table id="cart">
                    <thead>
                        <tr>
                            <th class="first">Photo</th>
                            <th class="second">Qty</th>
                            <th class="third">Product</th>
                            <th class="fourth">Line Total</th>
                            <th class="fifth">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- shopping cart contents -->
                        <?php
                        $total = 0;
                        if (!empty($cart)) {
                            foreach ($cart as $key => $value) {
                                //print_r($value);
                                //echo $key . " : " . $value['quantity'] ."<br>";
                                $navcartsql = $this->db->query("SELECT * FROM items WHERE id=$key");
                                $navcartr = $navcartsql->result();
                                $total = $total + $navcartr[0]->price;
                                ?>
                                <tr class="productitm">
                                    <td><img src="<?php echo base_url('assets/uploads'); ?>/<?php echo @$navcartr[0]->item_image; ?>" height="60px;" width="60px;" class="thumb"></td>
                                    <td><input type="number" value="<?php echo $value['quantity']; ?>" min="0" max="99" class="qtyinput"></td>
                                    <td><?php echo @$navcartr[0]->name; ?></td>
                                    <td>INR <?php echo @$navcartr[0]->price; ?></td>
                                    <td><span class="remove"><a href="<?php echo base_url('items/deletecart'); ?>?id=<?php echo $key; ?>"><img src="<?php echo base_url(); ?>assets/images/trash.png" alt="X"></a></span></td>
                                </tr>
                            <?php } ?>
                            <!-- tax + subtotal -->
                            <tr class="extracosts">
                                <td class="light">Shipping &amp; Tax</td>
                                <td colspan="2" class="light"></td>
                                <td>INR 35.00</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="totalprice">
                                <td class="light">Total:</td>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="2"><span class="thick">INR <?php echo $total; ?></span></td>
                            </tr>
                        <?php } ?>

                        <!-- checkout btn -->
                    <form method="post">
                        <table class="tbl" width="60%" border="1" cellpadding="2" cellspacing="0">
            <!--                <tr>
                                <th width="40%">Field Description</th>
                                <th width="20%">Field Name</th>
                            </tr>-->

                            <select name="reqType" style="display: none;">
                                <option value="T">T</option>
                                <option value="S">S</option>
                                <option value="O">O</option>
                                <option value="R">R</option>
                                <option value="TNR">TNR</option>
                                <option value="TCI">TCI</option>
                                <option value="TWC">TWC</option>
                                <option value="TRC">TRC</option>
                                <option value="TCC">TCC</option>
                                <option value="TWI">TWI</option>
                                <option value="TIC">TIC</option>
                                <option value="TIO">TIO</option>
                                <option value="TWD">TWD</option>
                            </select>



                            <input type="hidden" name="mrctCode" value="L14130"/>


                            <input type="hidden" name="mrctTxtID" value="<?php echo $strNo; ?>"/>

                            <input type="hidden" name="currencyType" value="INR"/>
                            <input type="hidden" name="amount" value="<?php echo $total; ?>"/>
                            <input type="hidden" name="itc" value="NIC~TXN0001~122333~rt14154~8 mar 2014~Payment~forpayment"/>
                            <input type="hidden" name="reqDetail" value="Ritn_1.0_0.0"/>
                            <input type="hidden" name="txnDate" value="<?php echo $strCurDate; ?>"/>
                            <select name="locatorURL" style="display: none;">
                                <option value="https://www.tekprocess.co.in/PaymentGateway/TransactionDetailsNew.wsdl">TEST</option>
                                <option value="http://10.10.60.46:8080/PaymentGateway/services/TransactionDetailsNew">E2EWithIP</option>
                                <option value="https://tpslvksrv6046/PaymentGateway/services/TransactionDetailsNew">E2EWithDomain</option>
                                <option value="https://www.tekprocess.co.in/PaymentGateway/services/TransactionDetailsNew">UATWithDomain</option>
                                <option value="http://10.10.102.157:8081/PaymentGateway/services/TransactionDetailsNew">UATWithIP</option>
                                <option value="http://10.10.102.158:8081/PaymentGateway/services/TransactionDetailsNew">EAP UATWithIP</option>
                                <option selected value="https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl">LIVE</option>
                                <option value="http://10.10.60.247:8080/PaymentGateway/services/TransactionDetailsNew">Linux E2E</option>
                            </select>

                            <input type="hidden" name="s2SReturnURL" value="https://tpslvksrv6046/LoginModule/Test.jsp"/>

                            <input type="hidden" name="tpsl_txn_id" value="<?php echo 'TXN00' . rand(1, 10000); ?>"/>
                            <input type="hidden" name="custID" value="19872627"/>
                            <input type="hidden" name="custname" value="Test"/>
                            <input type="hidden" name="mobNo" value="45345353434"/>
                            <input type="hidden" name="key" value="3554118637DMBIRH"/>
                            <input type="hidden" name="iv" value="8456462358XRRFQF"/>
                            <input type="hidden" name="returnURL" value='<?php echo base_url('items/payment'); ?>'/>


                            <tr>
                                <td colspan=2>
                                    <button type="submit" class="checkout" name="submit" value="Submit" />Checkout Now!</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <tr class="checkoutrow">                       
                        <td colspan="5" class="checkout1"><a href="<?php echo base_url('items/dashboard'); ?>" id="submitbtn">Back</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>