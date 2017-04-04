<?php

namespace RevoSystems\ProductLabel;


class ProductLabel {
    private $json;
    private $values;
    private $mCurrentX;
    private $mCurrentY;

    public static function make($param) {
        $productLabel = new ProductLabel();
        $productLabel->json = $param;
        return $productLabel;
    }

    public function render($values = [], $times = 1, $skip = 0) {
        $this->values = $values;

        $this->mCurrentX   = 0;
        $this->mCurrentY   = 0;
        $times += $skip;
        $final = '<html><body style="width: 210mm;">';

        for($i = 0; $i < $times; $i++) {
            if ($skip <= $i) {
                $final  .= "<div style='" . $this->getBoxSizeStyle() . "'>" . $this->getObjects() . "</div>"; // . " outline:1px solid black"
            }
            $this->calculateNextLabelPosition();
        }
        return $final . '</body></html>';
    }

    public function getBoxSizeStyle() {
        $boxSizes = $this->getBoxSizes();
        return "position: absolute; left: {$this->mCurrentX}mm; top: {$this->mCurrentY}mm; width: {$boxSizes["width"]}mm; height: {$boxSizes["height"]}mm;";
    }

    public function getBoxSizes() {
        $paper =  $this->papers()[$this->json["paper"]];
        $height = $paper["height"];
        $width  = $paper["width"];

        if ($this->json["orientation"]  == "Portrait") {
            return ["width"=> $height, "height"=> $width];
        }
        return ["width" => $width, "height" => $height];
    }

    public function papers() {
        return [
            "1274"  => ["width" => 105.0,   "height" => 37.114 ],  //105  37.0
            "1284"  => ["width" => 52.5,    "height" => 21.216 ],  //52.5 21.2
            "1286"  => ["width" => 52.5,    "height" => 29.706 ],  //52.5 29.7
        ];
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

    public function calculateNextLabelPosition() {
        $boxSizes = $this->getBoxSizes();
        $this->mCurrentX += $boxSizes["width"];
        if ($this->mCurrentX + $boxSizes["width"] > 210.0+20) {
            $this->mCurrentX = 0;
            $this->mCurrentY += $boxSizes["height"];
        }
    }
}
