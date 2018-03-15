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

        return '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body style="width: 210mm;">'. $labelsHtml . '</body></html>';
    }

    public function renderLabel($product) {
        $times  = $product["times"];
        $times += $this->skip;

        $productLabel = ProductLabel::make($this->label, $product["values"]);
        for($i = 0, $htmlLabels = ''; $i < $times; $i++) {
            if ($this->skip <= $i) {
                $htmlLabels  .= "<div style='" . $this->getBoxSizeStyle($productLabel) . "'>" . $productLabel->getObjects() . "</div>"; // . " outline:1px solid black"
            }
            $this->moveCursorToNextLabel($productLabel);
        }
        $this->skip = 0;
        return $htmlLabels;
    }

    public function getBoxSizeStyle($productLabel) {
        return "position: absolute; left: {$this->mCurrentX}mm; top: {$this->mCurrentY}mm; width: {$productLabel->getWidth()}mm; height: {$productLabel->getHeight()}mm;";
    }

    public function moveCursorToNextLabel($productLabel) {
        $this->mCurrentX += $productLabel->getWidth();
        if ($this->mCurrentX + $productLabel->getWidth() > 210.0+20) {
            $this->mCurrentX = 0;
            $this->mCurrentY += $productLabel->getHeight();
        }
    }

}
