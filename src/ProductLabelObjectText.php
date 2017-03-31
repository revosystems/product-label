<?php

namespace RevoSystems\ProductLabel;


class ProductLabelObjectText extends ProductLabelObject {
    public function getBody() {
        return $this->json["text"];
    }

    public function getStyle() {
        return "{$this->getAlign()} {$this->getTextStyle()}";
    }

    public function getAlign() {
        if ( $this->json["align"]  == "start" || !$this->json["align"]) {
            return "text-align: left;";
        }
       return "text-align: {$this->json["align"]};";

    }

    public function getTextStyle() {
        return " font-family: {$this->getFontFamily()}; font-size: {$this->getFontSize()}; {$this->getBold()}";
    }

    public function getFontFamily() {
        if ($this->json["fontFamily"]) {
            return $this->json["fontFamily"];
        }
        return "Arial";
    }

    public function getFontSize() {
        if ($this->json["fontSize"]) {
            return $this->json["fontSize"];
        }
        return "12px";
    }

    public function getBold() {
        if ( $this->json["bold"] ) {
            return "font-weight: bold;";
        }
        return "";
    }
}