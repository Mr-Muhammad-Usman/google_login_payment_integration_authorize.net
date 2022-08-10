<?php

namespace App\Http\Controllers;

use App\Models\AuthPaymentModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class PaymentController extends Controller
{
    public function authorizePage()
    {
        return  view('Authorize_payment');
    }
    public function authorizePayment(Request $request)
    {

        $request->validate(array(
            'owner' => 'required',
            'cvv' => 'required',
            'cardNumber' => 'required',
            'expiration_month' => 'required',
            'expiration_year' => 'required',
        ));
        $input = $request->input();
        /* Create a merchantAuthenticationType object with authentication details
          retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('8Nkj6mCjH6x');
        $merchantAuthentication->setTransactionKey('7C8Fkc59Zrh85y95');

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);

        $creditCard->setexpirationDate($input['expiration_year'] . "-" .$input['expiration_month']);

        $creditCard->setCardCode($input['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount('99');
        $transactionRequestType->setPayment($paymentOne);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
//        dd($response);
        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
//                    echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
//                    echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
//                    echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
//                    echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
//                    echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "success_msg";
                    $order=new AuthPaymentModel();
                    $order->amount=99;
                    $order->response_code = $tresponse->getResponseCode();
                    $order->transaction_id = $tresponse->getTransId();
                    $order->auth_id =Auth::user()->id;
                    $order->message_code = $tresponse->getMessages()[0]->getCode();
                    $order->name_on_card = trim($input['owner']);
                    $order->quantity=1;
                    $order->save();
                    return redirect()->route('thankYouPage');
//                    dd($order);
//                    \App\Models\AuthPaymentModel::create([
//                        'amount' => $input['amount'],
//                        'response_code' => $tresponse->getResponseCode(),
//
//                        'auth_id' => $tresponse->getAuthCode(),
//                        'message_code' => $tresponse->getMessages()[0]->getCode(),
//                        'name_on_card' => trim($input['owner']),
//                        'quantity'=>1
//                    ]);
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg";

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                }
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "error_msg";
        }
//        dd($message_text);
        session()->flash('message_text',$message_text);
        return back();

    }

    public function thankYouPage()
    {
        return view('thankyou');
    }
    public function user_logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
    public function order()
    {
        $order=AuthPaymentModel::where('auth_id',Auth::user()->id)->get();
        return view('myorders',compact('order'));
    }
}
