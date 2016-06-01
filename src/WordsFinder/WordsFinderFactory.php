<?php

namespace WordsFinder;

use WordsFinder\Exception\WordsFinderException;

final class WordsFinderFactory
{
    public static function factory(array $wordsForSearch, $fileName)
    {
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        
        $className = "WordsFinderDefault";

        switch ($fileExt) {
            case 'doc':
            case 'docx':
                $className = "WordsFinderMsWord";
                break;
            case 'xls':
            case 'xlsx':
            case 'xlsm':
            case 'xltx':
            case 'xltm':
            case 'xlt':
            case 'ods':
            case 'ots':
            case 'slk':
            case 'xml':
                $className = "WordsFinderMsExcel";
                break;
            case 'ppt':
            case 'pptx':
            case 'ppsx':
                $className = "WordsFinderMsPowerPoint";
                break;
            default:
                $className = "WordsFinderDefault";
                break;
        }

        $classFileName = __DIR__ . "/" . $className . '.php';

        if (!file_exists($classFileName)) {
            throw new WordsFinderException("File words finder $classFileName not found");
        }

        include_once($classFileName);

        $classFullName = "WordsFinder\\$className";
        $object = new $classFullName($wordsForSearch, $fileName);

        return $object;
    }
}