<?php

namespace FileConverter;

use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\Filesystem\Exception\IOException;

final class ConverterDocx extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = $this->read_docx($fileName);

        if ($text) {
            return $text;
        } else {
            throw new IOException("Error loading file $fileName");
        }
    }

    public function getFooters($fileName)
    {
        $phpWord = IOFactory::load($fileName);

        $footers = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getFooters() as $footer) {
                foreach ($footer->getElements() as $f) {
                    try {
                        $footers .= $f->getText() . ", ";
                    } catch (\Exception $ex) {
                    }
                }
            }
        }

        return rtrim($footers, ', ');
    }

    public function getHeaders($fileName)
    {
        $phpWord = IOFactory::load($fileName);

        $headers = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getHeaders() as $header) {
                foreach ($header->getElements() as $h) {
                    try {
                        $headers .= $h->getText() . ", ";
                    } catch (\Exception $ex) {
                    }
                }
            }
        }

        return rtrim($headers, ', ');
    }

    /**
     * @param $fileName
     * @return array
     */
    public function getDocInfo($fileName)
    {
        parent::checkFileExist($fileName);

        $phpWord = IOFactory::load($fileName);
        $docInfo = (array)$phpWord->getDocInfo();
        $docInfoKeys = array_keys($docInfo);
        foreach ($docInfoKeys as &$docInfoKey) {
            $docInfoKey = str_replace("PhpOffice\\PhpWord\\Metadata\\DocInfo", '', $docInfoKey);
            $docInfoKey = trim($docInfoKey);
        }
        $docInfo = array_filter(array_combine($docInfoKeys, array_values($docInfo)));

        return $docInfo;
    }

    private function read_docx($filename)
    {

        $striped_content = '';
        $content = '';

        $zip = zip_open($filename);

        if (!$zip || is_numeric($zip)) {
            return false;
        }

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == false) {
                continue;
            }

            if (zip_entry_name($zip_entry) != "word/document.xml") {
                continue;
            }

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }
}