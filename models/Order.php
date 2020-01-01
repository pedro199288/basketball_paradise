<?php
class Order {
    private $id;
    private $user_dni;
    private $address;
    private $lines;
    private $status;
    private $purchaseDate;
    private $shippingDate;
    private $deliveryDate;

    public function constuct() {
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUserDni($userDni) {
        $this->userDni = $userDni;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setLines($lines) {
        $this->lines = $lines;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setPurchaseDate($purchaseDate) {
        $this->purchaseDate = $purchaseDate;
    }

    public function setShippingDate($shippingDate) {
        $this->shippingDate = $shippingDate;
    }

    public function setDeliveryDate($deliveryDate) {
        $this->deliveryDate = $deliveryDate;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserDni() {
        return $this->userDni;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getLines() {
        return $this->lines;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getPurchaseDate() {
        return $this->purchaseDate;
    }

    public function getShippingDate() {
        return $this->shippingDate;
    }

    public function getDeliveryDate() {
        return $this->deliveryDate;
    }

    public function save($updating = false){}

    public function addLine(){}
}