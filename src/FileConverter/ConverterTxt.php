<?php

namespace FileConverter;

final class ConverterTxt extends AbstractConverter
{
    public function __construct($fileName)
    {
        parent::checkFileExist($fileName);

        $this->fileName = $fileName;
    }

    /**
     * Get plain text from file
     * @return string
     */
    public function getText()
    {
        parent::checkFileExist($this->fileName);

        $text = '';
        
        try {
            $text = file_get_contents($this->fileName);
        } catch (\Exception $ex) {
            return '';
        }

        return $text;
    }
}