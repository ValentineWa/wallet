<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Deposit;
use yii\web\Controller;
use frontend\models\Mpesastkrequests;
use common\xyz\MpesaApi;
use frontend\models\Mpesac2bcallbacks;

class DepositController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    // public function beforeAction($action)
    // {
    //     if ($action->id == 'ipn' ) {
    //         $this->enableCsrfValidation = false;
    //     }
    //     return parent::beforeAction($action);
    // }
  
    public function actionAdeposit()
    {
        $model = new \frontend\models\Deposit();
        
        if (\Yii::$app->request->post()) {
            $response = $this->pay(\Yii::$app->request->post()['Deposit']);
            $this->processRespose($response,\Yii::$app->request->post());
        }
        
        return $this->renderAjax('adeposit', [
            'model' => $model,
        ]);
    }
    public function pay($postData){
        $mpesa_api = new MpesaApi();
       // var_dump($postData); exit();
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = $postData['transAmount'];
        $PhoneNumber = $postData['phoneCode'].$postData['mpesaNumber'];
        $PartyA = $postData['phoneCode'].$postData['mpesaNumber'];
        $PartyB = 174379;
     //   $UserId = $postData['userId'];
        // $CallBackURL = 'https://83e64dd2a933.ngrok.io/wallet/deposit/ipn';
        $CallBackURL = 'https://83e64dd2a933.ngrok.io/wallet/xyz/confirm?token=KUstudents51234567qwerty';
        $AccountReference =  $postData['details'];
        $TransactionDesc = $postData['details'];
        
        
        
        $configs = array(
            'AccessToken' => $this->generateToken(),
            'Environment' => 'sandbox',
            'Content-Type' => 'application/json',
            'Verbose' => 'true',
        );
        
        $api = 'stk_push';
        $LipaNaMpesaPasskey= 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $timestamp ='20'.date("ymdhis");
        $BusinessShortCode = 174379;
        
        $parameters = array(
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => base64_encode($BusinessShortCode.$LipaNaMpesaPasskey.$timestamp),
            'Timestamp' => $timestamp,
            'TransactionType' => $TransactionType,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'PhoneNumber' =>$PhoneNumber,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc,
        );
        
        $response = $mpesa_api->call($api, $configs, $parameters);
        return $response;
    }
    
    
    private function generateToken(){
        
        $mpesa_api = new MpesaApi();
        
        $configs = array(
            'Environment' => 'sandbox',
            'Content-Type' => 'application/json',
            'Verbose' => '',
        );
        
        $api = 'generate_token';
        
        $parameters = array(
            'ConsumerKey' => 'r51znrL5gElKFiWxUNFP2eDGowi45GTx',
            'ConsumerSecret' => 'xXY8dVegLHT2p3Ob',
        );
        
        $response = $mpesa_api->call($api, $configs, $parameters);
        return $response['Response']['access_token'];
        
    } 
    // public function processResponse($response)
    // {
    //     if (array_key_exists('errorCode', $response['Response'])) {
    //         $Msg = '<div class="alert alert-danger alert-dismissable" role="alert">
    //             <h3>THE FOLLOWING ERROR HAS ACCURED WHILE TRYING TO PROCESS YOUR REQUEST</h3>
    //              <h5> ERROR CODE: '.$response['Response']['errorCode'].'</h5>
    //              <h6>'.$response['Response']['errorMessage'].'</h6><h6>For more information Please Contact Support Via: 0727309037</h6>
    //             </div>';
    //         \Yii::$app->session->setFlash('error', $Msg);
    //          $this->redirect(['site/index']);
    //     }else{
            
    //         $Msg = '<div class="alert alert-success alert-dismissable" role="alert">
    //                       <h5> '.$response['Response']['CustomerMessage'].'</h5>
    //                   </div>';
    //         \Yii::$app->session->setFlash('success', $Msg);
            
    //         $this->redirect(['site/index']);
            
    //     }
    //     $this->redirect(['site/index']);
        
    // }
    // }
    public function processRespose($response,$postData) {
        $model = new \frontend\models\Deposit();
        if (array_key_exists('errorCode', $response['Response'])) {
            $model->load($postData);
            $model->save();
            $Msg = '<div class="alert alert-danger alert-dismissable" role="alert">
					<h3>THE FOLLOWING ERROR HAS ACCURED WHILE TRYING TO PROCESS YOUR REQUEST</h3>
					 <h5> ERROR CODE: '.$response['Response']['errorCode'].'</h5>
					 <h6>'.$response['Response']['errorMessage'].'</h6><h6>For more information Please Contact Your BabyGirl Via: 0705325040</h6>
					</div>';
            \Yii::$app->session->setFlash('error', $Msg);
            $this->redirect(['site/index']);
        }else{
            
            $model->load($postData);
            // $model->merchantrequestId = $response['Response']['MerchantRequestID'];
            if (array_key_exists('MerchantRequestID', $response['Response'])) {
                $model->merchantrequestId = $response['Response']['MerchantRequestID'];
            }  if (array_key_exists('MerchantRequestID', $response['Response'])) {
                $model->merchantrequestId = $response['Response']['MerchantRequestID'];
                 
            }
            $model->save();
            $Msg = '<div class="alert alert-success alert-dismissable" role="alert">
						  	<h5> '.$response['Response']['CustomerMessage'].'</h5>
						  </div>';
            \Yii::$app->session->setFlash('success', $Msg);
            $this->redirect(['site/index']);
            $this->saveRequestData($response,$postData['Deposit']['walletId']);
            
        }
    }


    // public function processRespose($response,$postData) {
    //     $model = new \frontend\models\Deposit();
        
    //     if (array_key_exists('errorCode', $response['Response'])) {
            
    //         $model->load($postData);
    //         $model->save();
    //         $Msg = '<div class="alert alert-danger alert-dismissable" role="alert">
	// 				<h3>THE FOLLOWING ERROR HAS ACCURED WHILE TRYING TO PROCESS YOUR REQUEST</h3>
	// 				 <h5> ERROR CODE: '.$response['Response']['errorCode'].'</h5>
	// 				 <h6>'.$response['Response']['errorMessage'].'</h6><h6>For more information Please Contact Support Via: 0727309037</h6>
	// 				</div>';
    //         \Yii::$app->session->setFlash('error', $Msg);
    //         $this->redirect(['site/index']);
    //     }else{
    //         $model->load($postData);
    //         if (array_key_exists('MerchantRequestID', $response['Response'])) {
    //             $model->MerchantRequestId = $response['Response']['MerchantRequestID'];
                
    //             $this->saveRequestData($response,$postData['Deposit']['walletId']);
                
    //             $Msg = '<div class="alert alert-success alert-dismissable" role="alert">
	// 					  	<h5> '.$response['Response']['CustomerMessage'].'</h5>
	// 					  </div>';
    //             \Yii::$app->session->setFlash('success', $Msg);
    //         }
    //         $model->save();
    //         $this->redirect(['site/index']);
    //     }
        
    // }
    public function saveRequestData($response,$walletId){
        
        $model = new Mpesastkrequests();
        
        $model->amount = $response['Parameters']['Amount'];
        $model->phone = $response['Parameters']['PhoneNumber'];
        $model->reference = $response['Parameters']['AccountReference'];
        $model->description = $response['Parameters']['TransactionDesc'];
        $model->CheckoutRequestID = $response['Response']['CheckoutRequestID'];
        $model->MerchantRequestID = $response['Response']['MerchantRequestID'];
        $model->walletId = $walletId;
        $model->userId = \yii::$app->user->Id;
        
        $model->save();
        
        return $model;
        
    }

//Ipn=instant payment notification//
    // public function SaveData($request)
    // {
    //     $model = New Mpesac2bcallbacks();
    //     $request = json_decode($request,true);
        
    //     $model->MerchantRequestID = 'Test2';
    //     $model->CheckoutRequestID = 'Test';
    //     $model->ResultCode = '123'; 
    //     $model->request = $request;
    //     $model->ResultDesc = 'Test2';
    //     $model->transAmount = '0.00';
    //     $model->MpesaReceiptNumber = 'TEST2';
    //     $model->TransactionDate = 'Test';
    //     $model->PhoneNumber = 'Test';

    //     $model->save();
    // }

    /**
     * Action IPN
     */
    
    // public function actionIpn()
    // {
    //     header("Content-Type:application/json");
        
    //     if (!isset($_GET["token"]))
    //     {
    //         echo "Technical error";
    //         exit();
    //     }
        
    //     if ($_GET["token"]!='KUstudents51234567qwerty')
    //     {
    //         echo "Invalid authorization";
    //         exit();
    //     }
        
    //     if (!$request=file_get_contents('php://input'))
        
    //     {
    //         echo "Invalid input";
    //         exit();
    //     }
        
        
    //     $this->SaveData($request);
    // }
    
   
}
