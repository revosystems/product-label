<?php

namespace RevoSystems\ProductLabel;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\Exceptions\InvalidLengthException;

class ProductLabelObjectWithBarcode extends ProductLabelObjectWithText
{
    public function getBody()
    {
        return $this->getBarcode($this->json['text'] ?? '');
    }

    public function getBarcode(string $text)
    {
        $generator    = new BarcodeGeneratorPNG();
        try {
            $barcodeImage = $generator->getBarcode($text, $generator::TYPE_CODE_39E, 1, $this->json['height']);
        } catch (InvalidLengthException $e) {
            return '';
        }
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
