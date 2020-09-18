<?php

namespace RevoSystems\ProductLabel;

class ProductLabelObjectWithValue extends ProductLabelObjectWithText
{
    public function getBody()
    {
        return $this->values[$this->json['valueId']];
    }
}
