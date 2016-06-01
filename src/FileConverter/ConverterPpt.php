<?php

namespace FileConverter;

use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Shape\RichText;

final class ConverterPpt extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = '';

        try {
            $objPHPPowerPoint = IOFactory::load($fileName);
            foreach ($objPHPPowerPoint->getAllSlides() as $slide) {
                foreach ($slide->getShapeCollection() as $shape) {
                    if ($shape instanceof RichText) {
                        /**
                         * @var RichText $shape
                         */
                        $text .= $shape->getPlainText() . "\n";
                    }
                }
            }
        } catch (\Exception $ex) {
            return '';
        }

        return $text;
    }


    /**
     * @param $fileName
     * @return array
     */
    public function getPptInfo($fileName)
    {
        parent::checkFileExist($fileName);

        $objPHPExcel = IOFactory::load($fileName);
        $pptInfo = (array)$objPHPExcel->getDocumentProperties();
        
        $pptInfoKeys = array_keys($pptInfo);
        foreach ($pptInfoKeys as &$pptInfoKey) {
            $pptInfoKey = str_replace("PhpOffice\\PhpPresentation\\DocumentProperties", '', $pptInfoKey);
            $pptInfoKey = trim($pptInfoKey);
        }
        $pptInfo = array_filter(array_combine($pptInfoKeys, array_values($pptInfo)));

        return $pptInfo;
    }
}