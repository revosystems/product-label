<?php

namespace RevoSystems\ProductLabel;


class ProductLabelObjectValueBarcode extends ProductLabelObjectBarcode {
    public function getBody() {
        return $this->getBarcode($this->values[$this->json["valueId"]]);
    }
}