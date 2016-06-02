<?php

namespace FileConverter;

final class ConverterTxt extends AbstractConverter
{
    /**
     * Get plain text from file
     * @param string $fileName
     * @return string
     */
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = '';
        
        try {
            $text = file_get_contents($fileName);
        } catch (\Exception $ex) {
            return '';
        }

        return $text;
    }
}