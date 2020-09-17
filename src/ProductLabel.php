<?php

namespace RevoSystems\ProductLabel;

class ProductLabel
{
    private $json;
    private $values;
    private $width;
    private $height;
    private $marginW;
    private $marginH;
    private $promotion;

    public static function make($label, $values, $promotion = null)
    {
        $productLabel           = new ProductLabel();
        $productLabel->json     = $label;
        $productLabel->values   = $values;
        $productLabel->promotion = $promotion;
        $productLabel->initBoxSizes();
        return $productLabel;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getMarginW()
    {
        return $this->marginW;
    }

    public function getMarginH()
    {
        return $this->marginH;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function initBoxSizes()
    {
        $papers         = require('labelPapers.php');
        $this->height   = $papers[$this->json['paper']]['height'];
        $this->width    = $papers[$this->json['paper']]['width'];
        $this->marginW  = $papers[$this->json['paper']]['margin-w'] ?? 0;
        $this->marginH  = $papers[$this->json['paper']]['margin-h'] ?? 0;

        if ($this->json['orientation'] == 'Portrait') {
            $this->toggleOrientation();
        }
    }

    public function getObjects()
    {
        return array_reduce($this->json['objects'], function ($carry, $object) {
            return "{$carry}{$this->getObject((array) $object)}";
        }, $carry = '');
    }

    public function getObject($object)
    {
        $labelObject = $this->availableObjectClasses()[$object['type']];
        $labelObject = new $labelObject;
        return $labelObject->render($object, $this->values);
    }

    public function availableObjectClasses()
    {
        return [
            'text'         => ProductLabelObjectText::class,
            'value'        => ProductLabelObjectValue::class,
            'barcode'      => ProductLabelObjectBarcode::class,
            'valueBarcode' => ProductLabelObjectValueBarcode::class,
            'valuePromotion' => ProductLabelObjectValuePromotion::class,
        ];
    }

    private function toggleOrientation()
    {
        list($this->width, $this->height) = [$this->height, $this->width];
    }
}
