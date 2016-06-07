<?php

namespace FileConverter;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class ConverterDoc
 * @package FileConverter
 */
final class ConverterDoc extends ConverterDocx
{

    public function __construct($fileName)
    {
        parent::__construct($fileName, 'MsDoc');
    }

    /**
     * Get plain text from file
     * @return string
     */
    public function getText()
    {
        $text = $this->read_doc($this->fileName);

        if ($text) {
            return $text;
        } else {
            throw new IOException("Error loading file " . $this->fileName);
        }
    }

    /**
     * Get .doc plain text
     * @param string $filename
     * @return string
     */
    private function read_doc($filename)
    {
        $fileHandle = fopen($filename, "r");
        $line = @fread($fileHandle, filesize($filename));
        $lines = explode(chr(0x0D), $line);
        $outtext = "";
        foreach ($lines as $thisline) {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== false) || (strlen($thisline) == 0)) {
            } else {
                $outtext .= $thisline . " ";
            }
        }
        $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", "", $outtext);
        return $outtext;
    }
    
}