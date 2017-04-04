<?php

namespace RevoSystems\ProductLabel;


class ProductLabelPage {
    private $products;
    private $skip;
    private $mCurrentX = 0;
    private $mCurrentY = 0;

    public static function make($products) {
        $productLabelPage = new ProductLabelPage();
        $productLabelPage->products = $products;
        return $productLabelPage;
    }

    public function render($skip = 0) {
        $this->skip = $skip;
        $html = array_reduce($this->products, function($carry, $product) {
            return $carry . $this->renderLabel($product);
        }, '<html><body style="width: 210mm;">');
        return $html . '</body></html>';
    }

    public function renderLabel($product) {
        $productLabel = ProductLabel::make($product["label"], $this->mCurrentX, $this->mCurrentY);
        $htmlLabels = $productLabel->render($product["values"], $product["times"], $this->skip);
        $this->mCurrentX = $productLabel->mCurrentX;
        $this->mCurrentY = $productLabel->mCurrentY;
        $this->skip = 0;
        return $htmlLabels;
    }
}
