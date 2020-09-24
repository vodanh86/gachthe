<?php

namespace frontend\controllers;

use Yii;
use app\models\Request;
use yii\web\Controller;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Response;
use yii\base\Event;

/**
 * RequestController implements the CRUD actions for Request model.
 */
class ApiController extends Controller
{
    const URL = "https://api.napthe24.net/PublicApi/themLenh";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'them-lenh' => ['POST'],
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
            ],
        ];
    }

    public function beforeAction($action)
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
        /*Yii::$app->response->on(
            Response::EVENT_BEFORE_SEND,
            [$this, 'beforeResponseSend']
        );*/
    }

    public function beforeResponseSend(Event $event)
    {
        /**
         * @var \yii\web\Response $response
         */
        $response = $event->sender;
        if (array_key_exists('status', $response->data)  && $response->data['status'] == 401) {
            $response->data = [
                'code' =>  401,
                'name' => 'Unauthorized',
                'message' => 'Unauthorized',
            ];
        }
    }

    public function make_request($request){
        $ch = curl_init(self::URL);
        # Setup request to send json via POST.
        $payload = json_encode( $request);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        $err = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);
       
        $request->status = $err;
        $request->response = $result;
        $request->update();
        return array("code" => $err,
                    "data" => $result);
                    }
    /**
     * Lists all Request models.
     * @return mixed
     */
    public function actionIndex()
    {
        return Request::find()->all();
    }

        /**
     * Lists all Request models.
     * @return mixed
     */
    public function actionThemlenh()
    {
        $result = array("code" => -1);
        foreach (array("Account", "Carry", "TopupAccType", "Amount", "MinCardValue", "CachNap", "Type") as $field){
            if (is_null(Yii::$app->request->post($field))){
                $result["message"] = $field." phải khác rỗng";
                return $result;
            }
            if (!is_numeric(Yii::$app->request->post($field))){
                $result["message"] = $field." phải là dạng số";
                return $result;     
            }
            if (strlen(strval(Yii::$app->request->post($field))) > 50){
                $result["message"] = $field." phải ngắn hơn 50 ký tự";
                return $result;     
            }
        }
        foreach (array("Note", "callbackUrl", "TranID") as $field){
            if (strlen(strval(Yii::$app->request->post($field))) > 50){
                $result["message"] = $field." phải ngắn hơn 50 ký tự";
                return $result;     
            }
        }

        $Account = Yii::$app->request->post("Account");
        $Carry = Yii::$app->request->post("Carry");
        $TopupAccType = Yii::$app->request->post("TopupAccType");
        $Amount = Yii::$app->request->post("Amount");
        $MinCardValue = Yii::$app->request->post("MinCardValue");
        $Note = Yii::$app->request->post("Note");
        $CachNap = Yii::$app->request->post("CachNap");
        $Type = Yii::$app->request->post("Type");
        $ChuyenMangGiuSo = Yii::$app->request->post("ChuyenMangGiuSo");
        $Daugia = Yii::$app->request->post("Daugia");
        $callbackUrl = Yii::$app->request->post("callbackUrl");
        $thoigiancho = Yii::$app->request->post("thoigiancho");
        $TranID = Yii::$app->request->post("TranID");

        if (!($Carry == 0 || $Carry == 1 || $Carry == 2)){
            $result["message"] = "Carry = 0 cho Viettel, 1 cho Vinaphone, 2 cho Mobifone";
            return $result;
        }
        if (!($TopupAccType == 0 || $TopupAccType == 1 )){
            $result["message"] = "TopupAccType = 0 cho trả trước, 1 cho trả sau";
            return $result;
        }
        if (!$TranID){
            $result["message"] = "TranID phải khác rỗng";
            return $result;
        }

        $DictCarry = array("viettel", "vinaphone", "mobifone");
        $DictTopup = array("tratruoc", "trasau");

        $request = new Request();
        $request->user_id = Yii::$app->user->id;
        $request->account = strval($Account);
        $request->carry = $DictCarry[$Carry];
        $request->topup_acc_type = $DictTopup[$TopupAccType];
        $request->amount = $Amount;
        $request->min_card_value = $MinCardValue;
        $request->note = $Note;
        $request->cach_nap = $CachNap;
        $request->type = $Type;
        $request->dau_gia = $Daugia;
        $request->chuyen_mang_giu_su = $ChuyenMangGiuSo;
        $request->callback_url = $callbackUrl;
        $request->thoi_gian_cho = $thoigiancho;
        $request->tran_id = strval($TranID);

        if ($request->save()) {
            /*$result = array(
                "code" => 0,
                "message" => "Tao lenh thanh cong",
                "data" => $this->make_request($request)
            );*/
            return $this->make_request($request);
        } else {
            $result["message"] = $request->getErrors();
        }

        return $result;
    }

    public function actionChitietlenh($id=null, $TranId=null){
        $request = null;
        if (!is_null($id)){
            $request = Request::findOne([
                'id' => $id,
                'user_id' => Yii::$app->user->id
            ]);
        }
        if (!is_null($TranId)){
            $request = Request::findOne([
                'tran_id' => $TranId,
                'user_id' => Yii::$app->user->id
            ]);
        }
        if (is_null($request)) {
            return array();
        }
        return $request;
    }

}
