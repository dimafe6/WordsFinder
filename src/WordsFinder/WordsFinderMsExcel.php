<?php

namespace WordsFinder;

use FileConverter\ConverterDocx;
use FileConverter\ConverterXls;
use FileConverter\FormatFactory;

final class WordsFinderMsExcel extends AbstractWordsFinder
{
    public function proceedFile($fileName)
    {
        $fname = basename($fileName);

        $resultForText = parent::proceedFile($fileName);
        $resultForXlsInfo = $this->getResultForXlsInfo($fileName);

        $result[$fname]['text'] = $resultForText[$fname]['text'];
        $result[$fname]['DocInfo'] = $resultForXlsInfo;

        $result[$fname] = array_filter($result[$fname]);

        return $result;
    }

    private function getResultForXlsInfo($fileName)
    {
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        /**
         * @var ConverterXls $converter
         */
        $converter = FormatFactory::factory($fileExt);
        $xlsInfo = $converter->getXlsInfo($fileName);
        foreach ($xlsInfo as &$item) {
            $item = parent::proceedText($item);
        }
        $xlsInfo = array_filter($xlsInfo);

        return $xlsInfo;
    }
}