<?php

namespace FileConverter;

use FileConverter\Exception\FileConverterException;

/**
 * Class FormatFactory
 * @package FileConverter
 */
final class FormatFactory
{
    /**
     * Get converter from file type
     * @param string $fileName File name
     * @return ConverterInterface
     */
    public static function factory($fileName)
    {
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        $className = "ConverterTxt";

        switch ($fileExt) {
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
            case 'gnumeric':
                $className = "ConverterXls";
                break;
            case 'ppt':
            case 'pptx':
            case 'ppsx':
                $className = "ConverterPpt";
                break;
            case 'txt':
                $className = "ConverterTxt";
                break;
            default:
                $className = "Converter" . ucfirst($fileExt);
                break;
        }

        $classFileName = __DIR__ . "/" . $className . '.php';

        if (!file_exists($classFileName)) {
            throw new FileConverterException("File converter $classFileName not found");
        }

        include_once($classFileName);

        $classFullName = "FileConverter\\$className";
        $object = new $classFullName($fileName);

        return $object;
    }
}