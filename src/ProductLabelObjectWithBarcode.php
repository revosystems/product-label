<?php

namespace RevoSystems\ProductLabel;

use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductLabelObjectWithBarcode extends ProductLabelObjectWithText
{
    public function getBody()
    {
        return $this->getBarcode($this->json['text']);
    }

    public function getBarcode($text)
    {
        $generator    = new BarcodeGeneratorPNG();
        $barcodeImage = $generator->getBarcode($text, $generator::TYPE_CODE_39, 1, $this->json['height']);
        return '<img style="height:' . $this->getSize() . ';width:' . $this->json['width'] . 'px;" src="data:image/png;base64,' . base64_encode($barcodeImage) . '">';
    }

    public function getTextStyle()
    {
        return "font-size: {$this->getSize()}";
    }

    public function getSize()
    {
        if ($this->json['barcodeSize'] == 'Medium') {
            return '24px';
        } elseif ($this->json['barcodeSize'] == 'Large') {
            return '35px';
        }
        return '20px';
    }
}
