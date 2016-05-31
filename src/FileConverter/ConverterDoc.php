<?php

namespace FileConverter;

final class ConverterDoc extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = '';

        try {
            $text = $this->read_doc($fileName);

        } catch (\Exception $ex) {
            return '';
        }

        return $text;
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