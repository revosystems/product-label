<?php

namespace RevoSystems\ProductLabel;


class ProductLabelObjectValue extends ProductLabelObjectText {
    public function getBody() {
        return $this->json[$this->json["valueId"]];
    }
}