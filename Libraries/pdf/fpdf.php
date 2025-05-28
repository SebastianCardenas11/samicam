<?php
/**
 * FPDF - Free PDF generation library
 * 
 * This is a simplified version of FPDF for SAMICAM
 */
class FPDF {
    // Current page orientation (P = Portrait, L = Landscape)
    protected $orientation;
    
    // Unit of measure (pt, mm, cm, in)
    protected $unit;
    
    // Page format (A4, Letter, etc)
    protected $format;
    
    // Current page width and height
    protected $w, $h;
    
    // Current position
    protected $x, $y;
    
    // Left, top, right margins
    protected $lMargin, $tMargin, $rMargin;
    
    // Current font
    protected $fontFamily, $fontStyle, $fontSize;
    
    // Page content
    protected $pages = [];
    protected $page = 0;
    protected $currentPage = '';
    
    // Document title
    protected $title = '';
    
    // Constructor
    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4') {
        $this->orientation = strtoupper($orientation);
        $this->unit = $unit;
        $this->format = $format;
        
        // Set page dimensions
        if($this->orientation == 'P') {
            $this->w = 210;
            $this->h = 297;
        } else {
            $this->w = 297;
            $this->h = 210;
        }
        
        // Set margins
        $this->lMargin = 10;
        $this->tMargin = 10;
        $this->rMargin = 10;
        
        // Initialize position
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
        
        // Set default font
        $this->fontFamily = 'Arial';
        $this->fontStyle = '';
        $this->fontSize = 12;
    }
    
    // Add a new page
    public function AddPage($orientation = '') {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->currentPage = &$this->pages[$this->page];
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
    }
    
    // Set font
    public function SetFont($family, $style = '', $size = 0) {
        $this->fontFamily = $family;
        $this->fontStyle = $style;
        if($size > 0) {
            $this->fontSize = $size;
        }
    }
    
    // Set document title
    public function SetTitle($title) {
        $this->title = $title;
    }
    
    // Line break
    public function Ln($h = null) {
        if($h === null) {
            $h = $this->fontSize;
        }
        $this->x = $this->lMargin;
        $this->y += $h;
        $this->currentPage .= "<br>";
    }
    
    // Cell
    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '') {
        // Calculate text width
        $txt = htmlspecialchars($txt);
        
        // Handle alignment
        $alignText = '';
        if($align == 'C') {
            $alignText = 'text-align:center;';
        } elseif($align == 'R') {
            $alignText = 'text-align:right;';
        } else {
            $alignText = 'text-align:left;';
        }
        
        // Handle border
        $borderStyle = '';
        if($border == 1) {
            $borderStyle = 'border:1px solid black;';
        }
        
        // Handle fill
        $fillStyle = '';
        if($fill) {
            $fillStyle = 'background-color:#f0f0f0;';
        }
        
        // Create cell
        $style = "display:inline-block;width:{$w}mm;height:{$h}mm;{$borderStyle}{$alignText}{$fillStyle}";
        $this->currentPage .= "<div style=\"{$style}\">{$txt}</div>";
        
        // Update position
        if($ln == 1) {
            $this->x = $this->lMargin;
            $this->y += $h;
            $this->currentPage .= "<br>";
        } else {
            $this->x += $w;
        }
    }
    
    // MultiCell - for text that may wrap to multiple lines
    public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false) {
        // Calculate text width
        $txt = htmlspecialchars($txt);
        
        // Handle alignment
        $alignText = '';
        if($align == 'C') {
            $alignText = 'text-align:center;';
        } elseif($align == 'R') {
            $alignText = 'text-align:right;';
        } elseif($align == 'L') {
            $alignText = 'text-align:left;';
        } else {
            $alignText = 'text-align:justify;';
        }
        
        // Handle border
        $borderStyle = '';
        if($border == 1) {
            $borderStyle = 'border:1px solid black;';
        }
        
        // Handle fill
        $fillStyle = '';
        if($fill) {
            $fillStyle = 'background-color:#f0f0f0;';
        }
        
        // Create cell
        $style = "display:block;width:{$w}mm;min-height:{$h}mm;{$borderStyle}{$alignText}{$fillStyle}";
        $this->currentPage .= "<div style=\"{$style}\">{$txt}</div>";
        
        // Update position
        $this->x = $this->lMargin;
        $this->y += $h;
    }
    
    // Image
    public function Image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '') {
        if($x === null) {
            $x = $this->x;
        }
        if($y === null) {
            $y = $this->y;
        }
        
        // Check if file exists
        if(!file_exists($file)) {
            return;
        }
        
        // Get image dimensions if not specified
        if($w == 0 && $h == 0) {
            $size = getimagesize($file);
            $w = $size[0] / 2.83; // Convert pixels to mm (72 dpi)
            $h = $size[1] / 2.83;
        } elseif($w == 0) {
            $size = getimagesize($file);
            $w = $h * $size[0] / $size[1];
        } elseif($h == 0) {
            $size = getimagesize($file);
            $h = $w * $size[1] / $size[0];
        }
        
        // Add image to page
        $style = "position:absolute;left:{$x}mm;top:{$y}mm;width:{$w}mm;height:{$h}mm;";
        $this->currentPage .= "<img src=\"{$file}\" style=\"{$style}\">";
    }
    
    // Output PDF
    public function Output($name = '', $dest = '') {
        // Generate HTML content
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">';
        $html .= '<title>' . htmlspecialchars($this->title) . '</title>';
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; text-align: center; }';
        $html .= '.content { max-width: 800px; margin: 0 auto; }';
        $html .= '.report-table { width: 100%; border-collapse: collapse; }';
        $html .= '.report-table th, .report-table td { padding: 8px; text-align: left; }';
        $html .= '.report-header { background-color: #f8f9fa; padding: 15px; margin-bottom: 20px; text-align: center; }';
        $html .= '.report-title { font-size: 24px; font-weight: bold; margin-bottom: 5px; }';
        $html .= '.report-date { font-size: 14px; color: #666; }';
        $html .= '@media print { @page { size: ' . $this->format . ' ' . $this->orientation . '; margin: 0; } }';
        $html .= '.btn-container { text-align: right; margin: 10px 0; padding: 5px; background: #f0f0f0; }';
        $html .= '.btn { padding: 5px 10px; margin-right: 10px; cursor: pointer; color: white; border: none; border-radius: 4px; }';
        $html .= '.btn-print { background: #4CAF50; }';
        $html .= '.btn-back { background: #f44336; }';
        $html .= '.label { font-weight: bold; width: 30%; }';
        $html .= '.value { width: 70%; }';
        $html .= '</style>';
        $html .= '</head><body>';
        
        $html .= '<div class="content">';
        
        // Add print and back buttons at the top
        $html .= '<div class="btn-container">';
        $html .= '<button class="btn btn-print" onclick="window.print()">Imprimir</button>';
        $html .= '<button class="btn btn-back" onclick="window.history.back()">Volver</button>';
        $html .= '</div>';
        
        // Add header with title
        $html .= '<div class="report-header">';
        $html .= '<div class="report-title">' . htmlspecialchars($this->title) . '</div>';
        $html .= '<div class="report-date">Fecha de generación: ' . date('d/m/Y') . '</div>';
        $html .= '</div>';
        
        // Start table for content
        $html .= '<table class="report-table">';
        
        // Add page content
        foreach($this->pages as $page) {
            $html .= $page;
        }
        
        $html .= '</table>';
        $html .= '</div>'; // Close content div
        $html .= '</body></html>';
        
        // Output based on destination
        if($dest == 'D') {
            // Download
            if($name == '') {
                $name = 'document.pdf';
            }
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $name . '"');
            header('Cache-Control: max-age=0');
            echo $html;
        } else {
            // Default: display in browser
            if($name == '') {
                $name = 'document.pdf';
            }
            header('Content-Type: text/html; charset=utf-8');
            echo $html;
        }
    }
}