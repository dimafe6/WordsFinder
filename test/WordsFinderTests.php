<?php

namespace WordsFinder\WordsFinderTests;

use WordsFinder\DefaultWordsFinder;
use WordsFinder\WordsFinderManager;

class WordsFinderTests extends \PHPUnit_Framework_TestCase
{
    private $stopWords = ['aliquet', 'ipsum', 'Sharm'];

    private $searchFiles = [
        __DIR__ . '/testFiles/testFile.txt',
        __DIR__ . '/testFiles/testFile1.txt',
        __DIR__ . '/testFiles/testFile2.txt',
    ];

    private function getSearchFiles()
    {
        $searchFiles = [];
        $handle = opendir(__DIR__ . '/testFiles');

        while ($entry = readdir($handle)) {
            if ($entry != "." && $entry != "..") {
                $searchFiles[] = __DIR__ . '/testFiles/' . $entry;
            };
        }
        closedir($handle);

        return $searchFiles;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateWordsFinder()
    {
        $wfm = new WordsFinderManager($this->stopWords, []);
    }

    public function testProceedFile()
    {
        $assertResult = [
            'testFile.txt' => ['text' => 3]
        ];

        $swf = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/testFile.txt']);
        $result = $swf->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testDocx()
    {
        $assertResult = [
            'test.docx' => ['text' => 1, 'footers' => 1]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.docx']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testDoc()
    {
        $assertResult = [
            'test.doc' => ['text' => 2]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.doc']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testPdf()
    {
        $assertResult = [
            'test.pdf' => ['text' => 3]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.pdf']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testXls()
    {
        $assertResult = [
            'test.xls' => ['text' => 3]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xls']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testXlsx()
    {
        $assertResult = [
            'test.xlsx' => ['text' => 3, 'DocInfo' => ['title' => 1]]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xlsx']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testXlt()
    {
        $assertResult = [
            'test.xlt' => ['text' => 3]
        ];
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xlt']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testXlsm()
    {
        $assertResult = [
            'test.xlsm' => ['text' => 3, 'DocInfo' => ['keywords' => 1]]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xlsm']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testXltx()
    {
        $assertResult = [
            'test.xltx' => ['text' => 3]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xltx']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testXltm()
    {
        $assertResult = [
            'test.xltm' => ['text' => 3]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xltm']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testOds()
    {
        $assertResult = [
            'test.ods' => ['text' => 3]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.ods']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testSlk()
    {
        $assertResult = [
            'test.slk' => ['text' => 2]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.slk']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testXml()
    {
        $assertResult = [
            'test.xml' => ['text' => 1]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xml']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);
    }

    public function testPptx()
    {
        $assertResult = [
            'test.ppsx' => ['text' => 2]
        ];

        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.ppsx']);
        $result = $wfm->run();

        $this->assertEquals($assertResult, $result);

    }

    public function testProceedAllFiles()
    {
        $assertResult = [
            'testFile1.txt' => [
                'text' => 15
            ],
            'test.xls' => [
                'text' => 3
            ],
            'test.xml' => [
                'text' => 1
            ],
            'test.xlsm' => [
                'text' => 3,
                'DocInfo' => [
                    'keywords' => 1
                ]
            ],
            'test.xlt' => [
                'text' => 3
            ],
            'test.docx' => [
                'text' => 1,
                'footers' => 1
            ],
            'test.rtf' => [
                'text' => 3
            ],
            'testFile2.txt' => [
                'text' => 6
            ],
            'test.xltm' => [
                'text' => 3
            ],
            'testFile.txt' => [
                'text' => 3
            ],
            'test.ods' => [
                'text' => 3
            ],
            'test.ppsx' => [
                'text' => 2
            ],
            'test.pdf' => [
                'text' => 3
            ],
            'test.xltx' => [
                'text' => 3
            ],
            'test.slk' => [
                'text' => 2
            ],
            'test1.pptx' => [
                'text' => 2,
                'DocInfo' => [
                    'keywords' => 2,
                    'category' => 1
                ]
            ],
            'test.xlsx' => [
                'text' => 3,
                'DocInfo' => [
                    'title' => 1
                ]
            ],
            'test.doc' => [
                'text' => 2
            ]
        ];


        $wfm = new WordsFinderManager($this->stopWords, $this->getSearchFiles());
        $result = $wfm->run();
        $this->assertEquals($assertResult, $result);
        echo "\n";
        print_r($result);
    }
}
