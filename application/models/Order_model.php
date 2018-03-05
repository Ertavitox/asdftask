<?php
require_once APPPATH . "third_party/BaseModel.php";
require_once APPPATH . "models/Entities/Order.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order_model
 *
 * @author Balázs
 */
class Order_model extends BaseModel {

    function __construct() {
        parent::__construct();
    }

    public function create($data) {
        if (!$data['shopOrderId'] || !$data['shopId'] || !$data['updatedAt'] || !is_numeric($data['shopOrderId']) || !is_string($data['shopId']) || !is_object($data['updatedAt'])) {
            return array('code' => 400, 'data' => array('message' => 'The input is invalid. The message body in the response is empty.'));
        }
        $order = $this->o_doctrine
                ->getRepository(Order::class)
                ->findOneBy(array(
            'shopOrderId' => $data['shopOrderId'],
            'shopId' => $data['shopId']
        ));
        if ($order) {
            return array('code' => 409, 'data' => array('message' => 'The order is already exists.'));
        } else {
            try {
                $order = new Order();
                $order->setAttributes($data);

                $this->o_doctrine->persist($order);
                $this->o_doctrine->flush();
                return array('code' => 201, 'data' => array('id' => $order->getId(), 'message' => 'Order created.'));
            } catch (Exception $ex) {
                return array('code' => 400, 'data' => array('message' => 'The input is invalid. The message body in the response is empty.'));
            }
        }
    }

    public function update($data) {
        if (!$data['shopOrderId'] || !$data['shopId'] || !$data['updatedAt'] || !is_numeric($data['shopOrderId']) || !is_string($data['shopId']) || !is_object($data['updatedAt'])) {
            return array('code' => 400, 'data' => array('message' => 'The request is invalid if the data is invalid.'));
        }
        $order = $this->o_doctrine
                ->getRepository(Order::class)
                ->findOneBy(array(
            'shopOrderId' => $data['shopOrderId'],
            'shopId' => $data['shopId']
        ));
        if ($order) {
            if ($order->getUpdatedAt() > $data['updatedAt']) {
                return array('code' => 409, 'data' => array('message' => 'There is conflict if the local updatedAt property is not lower than the sent value.'));
            } else {
                try {
                    $order->setUpdatedAt($data['updatedAt']);
                    $this->o_doctrine->persist($order);
                    $this->o_doctrine->flush();
                    return array('code' => 201, 'data' => array('id' => $order->getId(), 'message' => 'Order is successfully updated/replaced.'));
                } catch (Exception $ex) {
                    return array('code' => 400, 'data' => array('message' => 'The request is invalid if the data is invalid.'));
                }
            }
        } else {
            return array('code' => 404, 'data' => array('Order not found.'));
        }
    }

}
