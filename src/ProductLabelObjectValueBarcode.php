<?php

namespace RevoSystems\ProductLabel;

class ProductLabelObjectValueBarcode extends ProductLabelObjectWithBarcode
{
    public function getBody()
    {
        return $this->getBarcode($this->values[$this->json['valueId']]);
    }
}
