<?php

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class Order {

    protected $id;
    protected $shopOrderId;
    protected $shopId;
    protected $updatedAt;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getShopOrderId() {
        return $this->shopOrderId;
    }

    function getShopId() {
        return $this->shopId;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setShopOrderId($shopOrderId) {
        $this->shopOrderId = $shopOrderId;
    }

    function setShopId($shopId) {
        $this->shopId = $shopId;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setAttributes($data) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    function getAttributes() {
        return array(
            'id' => $this->getId(),
            'shopOrderId' => $this->getShopOrderId(),
            'shopId' => $this->getShopId(),
            'updatedAt' => $this->getUpdatedAt()
        );
    }

}
