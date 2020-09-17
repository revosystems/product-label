<?php

namespace RevoSystems\ProductLabel;

class ProductLabelObjectValuePromotion extends ProductLabelObjectValue
{
    public function getBody()
    {
        return $this->values['Promotions'][$this->json['valueId']["id"]] ?? '';
    }
}
