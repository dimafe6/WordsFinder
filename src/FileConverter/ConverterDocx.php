<?php

namespace FileConverter;

use Symfony\Component\Filesystem\Exception\IOException;

final class ConverterDocx extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = '';

        try {
            $text = $this->read_docx($fileName);

        } catch (\Exception $ex) {
            return '';
        }

        return $text;
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