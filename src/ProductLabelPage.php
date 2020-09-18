<?php

namespace RevoSystems\ProductLabel;

class ProductLabelPage
{
    private $label;
    private $products;
    private $skip;
    private $mCurrentX = 0;
    private $mCurrentY = 0;

    public static function make($label)
    {
        $productLabelPage        = new ProductLabelPage();
        $productLabelPage->label = $label;
        return $productLabelPage;
    }

    public function render($products, $skip = 0)
    {
        $this->products = $products;
        $this->skip     = $skip;
        $labelsHtml     = array_reduce($this->products, function ($carry, $product) {
            return $carry . $this->renderLabel($product);
        }, '');

        return '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body style="width: 210mm;">'. $labelsHtml . '</body></html>';
    }

    public function renderLabel($product)
    {
        $times  = $product['times'];
        $times += $this->skip;

        $this->productLabel = ProductLabel::make($this->label, $product['values']);
        $this->setMargins();
        for ($i = 0, $htmlLabels = $this->getSideMargin(); $i < $times; $i++) {
            if ($this->skip <= $i) {
                $htmlLabels .= "<div style='" . $this->getBoxSizeStyle() . "'>" . $this->productLabel->getObjects() . '</div>'; // . " outline:1px solid black"
            }
            $this->moveCursorToNextLabel();
        }
        $this->skip = $times;
        return $htmlLabels;
    }

    public function getBoxSizeStyle()
    {
        return "position: absolute; left: {$this->mCurrentX}mm; top: {$this->mCurrentY}mm; width: {$this->productLabel->getWidth()}mm; height: {$this->productLabel->getHeight()}mm;";
    }

    public function getSideMargin()
    {
        return "<div style='border: 1px solid red; position:absolute; left: {$this->productLabel->getMarginW()}mm'></div>";
    }
    
    public function moveCursorToNextLabel()
    {
        $this->mCurrentX += $this->productLabel->getWidth();
        if ($this->mCurrentX + $this->productLabel->getWidth() > (210.0 + 20 - $this->productLabel->getMarginW())) {
            $this->mCurrentX = $this->productLabel->getMarginW();
            $this->mCurrentY += $this->productLabel->getHeight();
        }
    }

    protected function setMargins()
    {
        $this->mCurrentX = $this->productLabel->getMarginW();
        $this->mCurrentY = $this->productLabel->getMarginH();
    }
}
