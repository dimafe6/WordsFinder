<?php

namespace FileConverter;


use PHPExcel;
use PHPExcel_IOFactory;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class ConverterXls
 * @package FileConverter
 */
final class ConverterXls extends AbstractConverter
{
    /**
     * @var PHPExcel
     */
    private $document;
    
    public function __construct($fileName)
    {
        parent::checkFileExist($fileName);

        if ($this->document == null || $this->fileName == null || $this->fileName !== $fileName) {
            $this->document = PHPExcel_IOFactory::load($fileName);
        }
        
        $this->fileName = $fileName;
    }
    
    /**
     * Get plain text from file
     * @return string
     */
    public function getText()
    {
        $text = '';
        $tempFile = __DIR__ . "/../../files/tmp.csv";

        try {
            $objWriter = PHPExcel_IOFactory::createWriter($this->document, 'CSV');
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
        $xlsInfo = (array)$this->document->getProperties();
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