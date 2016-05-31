<?php

namespace FileConverter;


use PHPExcel_IOFactory;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

final class ConverterXls extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = '';
        $tempFile = __DIR__ . "/../../files/tmp.csv";

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($fileName);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
            $objWriter->setDelimiter("\t");
            $objWriter->save($tempFile);

            if (!file_exists($tempFile)) {
                throw new FileNotFoundException("Error create temp file");
            }

            $text = file_get_contents($tempFile);

        } catch (\Exception $ex) {
            $text = '';
        }

        return $text;
    }


}