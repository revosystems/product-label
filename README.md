# ProductLabel package
## RevoSystems package to print labels from Revo Retail admin.
### Installation
Modify composer json to include productLabel repository

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:revosystems/productLabel.git"
    }
],
```
Install productLabel with composer.
```
composer require revosystems/productLabel
```

### Recommended usage

```
// Pass a json decoded label and products list to de LabelPage renderer.
$html = ProductLabelPage::make($label)->render($products);

// Now we can use any HtmlToPDF library to render it.
$pdf = SnappyPdf::loadHtml($html)
    ->setOption('zoom', 1.5636)    // Avoid html resize when printing.
    ->setOption('margin-top', 0)->setOption('margin-bottom', 0)
    ->setOption('margin-left', 0)->setOption('margin-right', 0);
return $pdf->inline('invoice.pdf');
```

Available papers:
```
[
    "1274"  => ["width" => 105.0,   "height" => 37.130 ],  //Default label size 105  37.0
    "1284"  => ["width" => 52.5,    "height" => 21.216 ],  //Default label size 52.5 21.2
    "1286"  => ["width" => 52.5,    "height" => 29.706 ],  //Default label size 52.5 29.7
];
```
