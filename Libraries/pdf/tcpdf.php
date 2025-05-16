<?php
// Clase TCPDF simplificada para generar PDFs
class TCPDF {
    protected $orientation;
    protected $unit;
    protected $format;
    protected $unicode;
    protected $encoding;
    protected $diskcache;
    protected $creator;
    protected $author;
    protected $title;
    protected $subject;
    protected $margins = ['left' => 15, 'top' => 15, 'right' => 15];
    protected $headerMargin = 5;
    protected $footerMargin = 10;
    protected $printHeader = true;
    protected $printFooter = true;
    protected $currentFont = ['family' => 'helvetica', 'style' => '', 'size' => 10];
    protected $fillColor = [255, 255, 255];
    protected $content = [];
    protected $pageWidth = 210; // A4 width in mm
    protected $pageHeight = 297; // A4 height in mm
    protected $currentY = 0;

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false) {
        $this->orientation = $orientation;
        $this->unit = $unit;
        $this->format = $format;
        $this->unicode = $unicode;
        $this->encoding = $encoding;
        $this->diskcache = $diskcache;
        $this->currentY = $this->margins['top'];
    }

    public function SetCreator($creator) {
        $this->creator = $creator;
    }

    public function SetAuthor($author) {
        $this->author = $author;
    }

    public function SetTitle($title) {
        $this->title = $title;
    }

    public function SetSubject($subject) {
        $this->subject = $subject;
    }

    public function SetMargins($left, $top, $right) {
        $this->margins = ['left' => $left, 'top' => $top, 'right' => $right];
    }

    public function SetHeaderMargin($margin) {
        $this->headerMargin = $margin;
    }

    public function SetFooterMargin($margin) {
        $this->footerMargin = $margin;
    }

    public function setPrintHeader($print) {
        $this->printHeader = $print;
    }

    public function setPrintFooter($print) {
        $this->printFooter = $print;
    }

    public function AddPage() {
        $this->content[] = "<div style='page-break-before: always;'></div>";
        $this->currentY = $this->margins['top'];
    }

    public function SetFont($family, $style = '', $size = 0) {
        $this->currentFont = ['family' => $family, 'style' => $style, 'size' => $size];
    }

    public function Ln($height = 0) {
        $this->currentY += $height;
        $this->content[] = "<div style='margin-top: {$height}mm;'></div>";
    }

    public function Cell($width, $height, $text = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '') {
        $style = "font-family: {$this->currentFont['family']}; ";
        
        if (strpos($this->currentFont['style'], 'B') !== false) {
            $style .= "font-weight: bold; ";
        }
        if (strpos($this->currentFont['style'], 'I') !== false) {
            $style .= "font-style: italic; ";
        }
        
        $style .= "font-size: {$this->currentFont['size']}pt; ";
        
        if ($align) {
            $style .= "text-align: " . ($align == 'C' ? 'center' : ($align == 'R' ? 'right' : 'left')) . "; ";
        }
        
        if ($border) {
            $style .= "border: 1px solid black; ";
        }
        
        if ($fill) {
            $rgb = "rgb({$this->fillColor[0]}, {$this->fillColor[1]}, {$this->fillColor[2]})";
            $style .= "background-color: $rgb; ";
        }
        
        if ($width > 0) {
            $style .= "width: {$width}mm; ";
        } else {
            $style .= "width: 100%; ";
        }
        
        $style .= "height: {$height}mm; display: inline-block; padding: 2mm; box-sizing: border-box; overflow: hidden;";
        
        $this->content[] = "<div style='$style'>$text</div>";
        
        if ($ln == 1) {
            $this->content[] = "<br>";
            $this->currentY += $height;
        }
    }

    public function SetFillColor($r, $g = null, $b = null) {
        if ($g === null && $b === null) {
            $this->fillColor = [$r, $r, $r];
        } else {
            $this->fillColor = [$r, $g, $b];
        }
    }

    public function Output($name = 'doc.pdf', $dest = 'I') {
        // Generar HTML
        $html = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>{$this->title}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }
                @media print {
                    @page {
                        size: {$this->format} {$this->orientation};
                        margin: {$this->margins['top']}mm {$this->margins['right']}mm {$this->footerMargin}mm {$this->margins['left']}mm;
                    }
                }
            </style>
        </head>
        <body onload='window.print()'>
            " . implode("\n", $this->content) . "
        </body>
        </html>";
        
        // Enviar cabeceras
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }
}