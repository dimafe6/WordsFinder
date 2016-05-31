<?php

namespace FileConverter;

use FileConverter\Exception\FileConverterException;

class FormatFactory
{
    public static function factory($fileType)
    {
        $className = "ConverterTxt";

        switch ($fileType) {
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
                $className = "ConverterT";
                break;
            default:
                $className = "Converter" . ucfirst($fileType);
                break;
        }

        $classFileName = __DIR__ . "/" . $className . '.php';

        if (!file_exists($classFileName)) {
            throw new FileConverterException("File converter $classFileName not found");
        }

        include_once($classFileName);

        $classFullName = "FileConverter\\$className";
        $object = new $classFullName;

        return $object;
    }
}