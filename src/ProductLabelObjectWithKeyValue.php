<?php

namespace RevoSystems\ProductLabel;

class ProductLabelObjectWithKeyValue extends ProductLabelObjectWithText
{
    public function getBody()
    {
        return $this->values['KeyValue'][$this->json['valueId']["id"]] ?? '';
    }
}
