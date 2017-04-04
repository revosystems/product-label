<?php

namespace RevoSystems\ProductLabel;


class ProductLabelPage {
    private $label;
    private $products;
    private $skip;
    private $mCurrentX = 0;
    private $mCurrentY = 0;

    public static function make($label) {
        $productLabelPage = new ProductLabelPage();
        $productLabelPage->label = $label;
        return $productLabelPage;
    }

    public function render($products, $skip = 0) {
        $this->products = $products;
        $this->skip = $skip;
        $labelsHtml = array_reduce($this->products, function($carry, $product) {
            return $carry . $this->renderLabel($product);
        }, '');

        return '<html><body style="width: 210mm;">'. $labelsHtml . '</body></html>';
    }

    public function renderLabel($product) {
        $productLabel = ProductLabel::make($this->label, $this->mCurrentX, $this->mCurrentY);
        $htmlLabels = $productLabel->render($product["values"], $product["times"], $this->skip);
        $this->mCurrentX = $productLabel->mCurrentX;
        $this->mCurrentY = $productLabel->mCurrentY;
        $this->skip = 0;
        return $htmlLabels;
    }
}
