<?php

namespace FileConverter;


use PHPExcel_IOFactory;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class ConverterXls
 * @package FileConverter
 */
final class ConverterXls extends AbstractConverter
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

    /**
     * Get document info
     * @param string $fileName
     * @return array
     */
    public function getXlsInfo($fileName)
    {
        parent::checkFileExist($fileName);

        $objPHPExcel = PHPExcel_IOFactory::load($fileName);
        $xlsInfo = (array)$objPHPExcel->getProperties();
        $xlsInfoKeys = array_keys($xlsInfo);
        foreach ($xlsInfoKeys as &$xlsInfoKey) {
            $xlsInfoKey = str_replace(":PHPExcel_DocumentProperties:private", '', $xlsInfoKey);
            $xlsInfoKey = str_replace("_", '', $xlsInfoKey);
            $xlsInfoKey = str_replace("PHPExcelDocumentProperties", '', $xlsInfoKey);
            $xlsInfoKey = trim($xlsInfoKey);
        }
        $xlsInfo = array_filter(array_combine($xlsInfoKeys, array_values($xlsInfo)));

        return $xlsInfo;
    }


}