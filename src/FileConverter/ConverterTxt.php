<?php

namespace FileConverter;

final class ConverterTxt extends AbstractConverter
{

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