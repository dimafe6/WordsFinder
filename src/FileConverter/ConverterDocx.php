<?php

namespace FileConverter;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class ConverterDocx
 * @package FileConverter
 */
class ConverterDocx extends AbstractConverter
{
    /**
     * @var PhpWord
     */
    protected $document = null;

    public function __construct($fileName, $readerName = 'Word2007')
    {
        parent::checkFileExist($fileName);

        if ($this->document == null || $this->fileName == null || $this->fileName !== $fileName) {
            $this->document = IOFactory::load($fileName, $readerName);
        }

        $this->fileName = $fileName;
    }

    /**
     * Get plain text from file
     * @return string
     */
    public function getText()
    {
        $text = $this->read_docx($this->fileName);

        if ($text) {
            return $text;
        } else {
            throw new IOException("Error loading file " . $this->fileName);
        }
    }

    /**
     * Get footers from .doc file
     * @return string
     */
    public function getFooters()
    {
        $footers = '';
        foreach ($this->document->getSections() as $section) {
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

    /**
     * Get headers from .doc file
     * @return string
     */
    public function getHeaders()
    {
        $headers = '';
        foreach ($this->document->getSections() as $section) {
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
     * Get document info
     * @return array
     */
    public function getDocInfo()
    {
        $docInfo = (array)$this->document->getDocInfo();
        $docInfoKeys = array_keys($docInfo);
        foreach ($docInfoKeys as &$docInfoKey) {
            $docInfoKey = str_replace("PhpOffice\\PhpWord\\Metadata\\DocInfo", '', $docInfoKey);
            $docInfoKey = trim($docInfoKey);
        }
        $docInfo = array_filter(array_combine($docInfoKeys, array_values($docInfo)));

        return $docInfo;
    }

    /**
     * Get .docx plain text
     * @param string $filename
     * @return string
     */
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