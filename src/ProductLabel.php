<?php

namespace RevoSystems\ProductLabel;


class ProductLabel {
    private $json;
    private $values;
    private $width;
    private $height;

    public static function make($label, $values) {
        $productLabel           = new ProductLabel();
        $productLabel->json     = $label;
        $productLabel->values   = $values;
        $productLabel->getBoxSizes();
        return $productLabel;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getBoxSizes() {
        $papers = require('labelPapers.php');
        $paper =  $papers[$this->json["paper"]];
        $this->height = $paper["height"];
        $this->width  = $paper["width"];

        if ($this->json["orientation"]  == "Portrait") {
            $this->toggleOrientation();
        }
    }

    public function getObjects() {
        return array_reduce($this->json["objects"], function ($carry, $object) {
            return "{$carry}{$this->getObject((array) $object)}";
        }, $carry = "");
    }

    public function getObject($object) {
        $labelObject = $this->availableObjectClasses()[$object["type"]];
        $labelObject = new $labelObject;
        return $labelObject->render($object, $this->values);
    }

    public function availableObjectClasses() {
        return [
            "text"         => ProductLabelObjectText::class,
            "value"        => ProductLabelObjectValue::class,
            "barcode"      => ProductLabelObjectBarcode::class,
            "valueBarcode" => ProductLabelObjectValueBarcode::class,
        ];
    }

    private function toggleOrientation(){
        list($this->width, $this->height) = array($this->height, $this->width);
    }
}
