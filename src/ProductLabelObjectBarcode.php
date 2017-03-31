<?php

namespace RevoSystems\ProductLabel;


class ProductLabelObjectBarcode extends ProductLabelObjectText {
    public function getBody() {
        return $this->getBarcode($this->json["text"]);
    }

    public function getBarcode($text) {
        $barcodeImage = (new UIImage())->barcode39($text, $this->json["width"], $this->json["height"]);
        return "<img src='data:image/png;base64,"
            //. RVPrinterDriver encodeToBase64String:barcodeImage
            . "'><br>";
    }

    public function getTextStyle() {
        return "font-size: {$this->getSize()}";
    }

    public function getSize() {
        if ($this->json["barcodeSize"] == "Medium" ) {
            return "24px";
        }
        else if ($this->json["barcodeSize"] == "Large" ) {
            return "35px";
        }
        return "20px";
    }
}