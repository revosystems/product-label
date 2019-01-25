<?php

namespace RevoSystems\ProductLabel;

class ProductLabelObjectText extends ProductLabelObject
{
    public function getBody()
    {
        return $this->json['text'];
    }

    public function getStyle()
    {
        return "{$this->getAlign()} {$this->getTextStyle()}";
    }

    public function getAlign()
    {
        if (! array_key_exists('align', $this->json) || $this->json['align'] == 'start') {
            return 'text-align: left;';
        }
        return "text-align: {$this->json['align']};";
    }

    public function getTextStyle()
    {
        return " font-family: {$this->getFontFamily()}; font-size: {$this->getFontSize()}; {$this->getBold()}";
    }

    public function getFontFamily()
    {
        if (array_key_exists('fontFamily', $this->json)) {
            return $this->json['fontFamily'];
        }
        return 'Arial';
    }

    public function getFontSize()
    {
        if (array_key_exists('fontSize', $this->json)) {
            return $this->json['fontSize'];
        }
        return '12px';
    }

    public function getBold()
    {
        if (array_key_exists('bold', $this->json)) {
            return 'font-weight: bold;';
        }
        return '';
    }
}
