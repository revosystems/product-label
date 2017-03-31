<?php

namespace RevoSystems\ProductLabel;


use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductLabelObjectBarcode extends ProductLabelObjectText {

    public function getBody() {
        return $this->getBarcode($this->json["text"]);
    }

    public function getBarcode($text) {
        $barcodeImage = (new BarcodeGeneratorPNG())->getBarcode(
            $text, BarcodeGeneratorPNG::TYPE_CODE_39); //, $this->json["width"], $this->json["height"]);  // widthFactor, totalHeight
        return "<img src='data:image/png;base64,{$barcodeImage}'><br>";

    }

    public function getTextStyle() {
        return "font-size: {$this->getSize()}";
    }

    public function getSize() {
        if      ($this->json["barcodeSize"] == "Medium" ) {
            return "24px";
        }
        else if ($this->json["barcodeSize"] == "Large"  ) {
            return "35px";
        }
        return "20px";
    }
}