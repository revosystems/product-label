<?php

namespace RevoSystems\ProductLabel;

use Barryvdh\Snappy\Facades\SnappyPdf;

class ProductLabel {
    const PAPER_WIDTH = 210.0;
    const PAPER_HEIGHT = 297.0;
    private $json;
    private $values;
    private $mCurrentX;
    private $mCurrentY;

    public static function make($param) {
        $productLabel = new ProductLabel();
        $productLabel->json = $param;
        return $productLabel;
    }

    public function pdf($values = [], $times = 1, $skip = 0) {
        $html = $this->render($values, $times, $skip);
        SnappyPdf::loadHtml($html)->setPaper('a4')->setOrientation('landscape')
            ->setOption('page-width', '210')
            ->setOption('margin-top', 0)->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0)->setOption('margin-right', 0)
            ->save(uniqid()."myLabel1.pdf");
//        SnappyPdf::loadHtml($html)->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0)->save(uniqid().'myLabel1.pdf');
    }

    public function render($values = [], $times = 1, $skip = 0) {
        $this->values = $values;

        $this->mCurrentX   = 0;
        $this->mCurrentY   = 0;
        $final = $this->getHtmlHeader();
        $times += $skip;

        for($i = 0; $i < $times; $i++) {
            if ($skip <= $i) {
                $final .= "<div style='" . $this->getBoxSizeStyle() . " outline:1px solid black;'>" . $this->getObjects() . "</div>";
//	        	$final .= "<div style='" . $this.getBoxSizeStyle() . "'>" . $this.getObjects() . "</div>";
            }
            $this->calculateNextLabelPosition();
        }
        return "{$final}</body></html>";
    }

    public function getHtmlHeader() {
        return "<html><head><style>
                @page{size:A4;margin:0;}@media print{html,body{width:" . static::PAPER_WIDTH . ";height:". static::PAPER_HEIGHT. "mm;}}
                </style><head></head><body style='width: ". static::PAPER_WIDTH ."mm'>";
    }

    public function getBoxSizeStyle() {
        $boxSizes = $this->getBoxSizes();
        return "position: absolute; left: {$this->mCurrentX}mm; top: {$this->mCurrentY}mm; width: {$boxSizes["width"]}mm; height: {$boxSizes["height"]}mm;";
    }

    public function getBoxSizes() {
        $paper =  $this->papers()[$this->json["paper"]];
        $height = $paper["height"];
        $width  = $paper["width"];

        if ($this->json["orientation"]  == "Portrait") {
            return ["width"=> $height, "height"=> $width];
        }
        return ["width" => $width, "height" => $height];
    }

    public function papers() {
        return [
            "1274"  => ["width" => 106.0,   "height" => 36.68 ],  //105  37.0
            "1284"  => ["width" => 53.0,    "height" => 20.53 ],  //52.5 21.2
//            "1284"  => ["width" => 53.0,    "height" => 20.96 ],  //52.5 21.2
            "1286"  => ["width" => 53.0,    "height" => 29.34 ],  //52.5 29.7
        ];
    }

    public function getObjects() {
        return array_reduce($this->json["objects"], function ($carry, $object) {
            return "{$carry}{$this->getObject((array) $object)}";
        }, $carry = "");
    }

    public function getObject($object) {
        $labelObject = new ProductLabelObject($this->availableObjectClasses()[$object["type"]]);
        return $labelObject->render($object, $this->values);
    }

    public function availableObjectClasses() {
        return [
            "text"         => ProductLabelObjectText::class,
            "value"        => ProductLabelObjectValue::class,
            "barcode"      => ProductLabelObjectBarcode::class,
            "valueBarcode" => ProductLabelObjectValueBarcode::class,
        ];
    }

    public function calculateNextLabelPosition() {
        $boxSizes = $this->getBoxSizes();
        $this->mCurrentX += $boxSizes["width"];
        if ($this->mCurrentX + $boxSizes["width"] > static::PAPER_WIDTH+20) {
            $this->mCurrentX = 0;
            $this->mCurrentY += $boxSizes["height"];
        }

    }
}
