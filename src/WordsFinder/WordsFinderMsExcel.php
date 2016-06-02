<?php

namespace WordsFinder;

use FileConverter\ConverterXls;
use FileConverter\FormatFactory;

/**
 * Class WordsFinderMsExcel
 * @package WordsFinder
 */
final class WordsFinderMsExcel extends AbstractWordsFinder
{
    /**
     * Process file
     * @param string $fileName
     * @return array
     */
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

    /**
     * Get result for document info
     * @param string $fileName
     * @return array
     */
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