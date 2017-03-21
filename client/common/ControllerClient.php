<?php

namespace client\common;

use framework\bin\base\AController;
use client\common\ResultClient;
use framework\bin\utils\ADesEncrypt;

/*
   * To change this license header, choose License Headers in Project Properties.
   * To change this template file, choose Tools | Templates
   * and open the template in the editor.
   */

/**
 * Description of ClientController
 *
 * @author zhaocj
 */
class ControllerClient extends AController
{

    //  private $clientResultData = null;
    protected $result;
    public $outputCategory = 'json'; //'json','obj'

    public function __construct($module = null, $action = null)
    {
        parent::__construct($module, $action);
        $this->init();
    }

    public function init()
    {

        parent::init();
        $this->result = new ResultClient();

        //校验令牌
        $this->authAccessToken();


    }

    /**
     * 令牌校验
     * return void
     */
    protected function authAccessToken()
    {
        $sessionId = $this->result->getSessionid();
        $token = $this->accessToken($sessionId);
        if (empty($this->params['accessToken'])) {
            ErrorCode::$ERRORACCESSTOKEN['message'] = $token;
            $this->result->setResult(ErrorCode::$ERRORACCESSTOKEN);
            $this->output($this->result);
            return;
        }
        if ($token !== $this->params['accessToken']) {
            $this->result->setResult(ErrorCode::$ERRORACCESSTOKENERROR);
            $this->output($this->result);
            return;
        }
    }

    /**
     * @param string $sessionId
     * @return string
     */
    protected function accessToken($sessionId)
    {
        return ADesEncrypt::encrypt($sessionId);
    }

    /**
     * 显示数据
     * @param ClientResultData $result
     * @return void
     */
    public function output(ClientResultData $result)
    {
        switch ($this->outputCategory) {
            case 'json':
                echo json_encode($result);
                break;
            default:
                echo var_export($result, true);
                break;
        }
    }

}
  