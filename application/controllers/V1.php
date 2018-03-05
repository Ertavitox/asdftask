<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller {
    
    public function __construct() {
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['order_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['order_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['order_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['order_put']['limit'] = 50; // 50 requests per hour per user/key
    }

    
    public function order_post(){
        //Load Order_Model
        $this->load->model('order_model');
        $date = $this->post('updatedAt');
        if($date){
            $date = new DateTime($date);
        }  
        
        $data = array(
            'shopId' => $this->post('shopId'),
            'shopOrderId' => $this->post('shopOrderId'),
            'updatedAt' => $date
        );
        
        $result = $this->order_model->create($data);
        header('Content-Type: application/json');
        $this->set_response($result['data'], $result['code']);
    }
    
    public function order_put(){
        //Load Order_Model
        $this->load->model('order_model');
        
        $date = $this->put('updatedAt');
        if($date){
            $date = new DateTime($date);
        }  
        
        $data = array(
            'shopId' => $this->put('shopId'),
            'shopOrderId' => $this->put('shopOrderId'),
            'updatedAt' => $date
        );
        $result = $this->order_model->update($data);
        header('Content-Type: application/json');
        $this->set_response($result['data'], $result['code']);
    }
    
}
