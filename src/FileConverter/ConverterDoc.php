<?php

namespace FileConverter;

use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\Filesystem\Exception\IOException;

final class ConverterDoc extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = $this->read_doc($fileName);

        if ($text) {
            return $text;
        } else {
            throw new IOException("Error loading file $fileName");
        }
    }

    public function getFooters($fileName)
    {
        $phpWord = IOFactory::load($fileName, 'MsDoc');

        $footers = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getFooters() as $footer) {
                foreach ($footer->getElements() as $f) {
                    try {
                        $footers .= $f->getText() . ", ";
                    } catch (\Exception $ex) {
                    }
                }
            }
        }

        return $footers;
    }

    public function getHeaders($fileName)
    {
        $phpWord = IOFactory::load($fileName, 'MsDoc');

        $headers = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getHeaders() as $header) {
                foreach ($header->getElements() as $h) {
                    try {
                        $headers .= $h->getText() . ", ";
                    } catch (\Exception $ex) {
                    }
                }
            }
        }

        return $headers;
    }

    public function getDocInfo($fileName)
    {
        parent::checkFileExist($fileName);

        $phpWord = IOFactory::load($fileName, 'MsDoc');
        $docInfo = (array)$phpWord->getDocInfo();
        $docInfoKeys = array_keys($docInfo);
        foreach ($docInfoKeys as &$docInfoKey) {
            $docInfoKey = str_replace("PhpOffice\\PhpWord\\Metadata\\DocInfo", '', $docInfoKey);
            $docInfoKey = trim($docInfoKey);
        }
        $docInfo = array_filter(array_combine($docInfoKeys, array_values($docInfo)));

        return $docInfo;
    }

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