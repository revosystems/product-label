<?php

namespace RevoSystems\ProductLabel;

class ProductLabelObject
{
    public $json;
    public $values;
    
    public function render($json, $values)
    {
        $this->json   = $json;
        $this->values = $values;
        return "<div style='{$this->getBoxStyle()}'>{$this->getBody()}</div>";
    }

    public function getBoxSize()
    {
        return "left: {$this->json['x']}px; top: {$this->json['y']}px; width: {$this->json['width']}px; height: {$this->json['height']}px; position: absolute;";
    }

    // ABSTRACT METHODS //
    public function getBoxStyle()
    {
        return "{$this->getBoxSize()} {$this->getStyle()}";
    }

    public function getStyle()
    {
        return '';
    }

    public function getBody()
    {
        return '';
    }
}
