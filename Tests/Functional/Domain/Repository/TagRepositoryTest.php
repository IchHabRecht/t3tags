<?php
namespace IchHabRecht\T3tags\Tests\Functional\Domain\Repository;

use IchHabRecht\T3tags\Domain\Repository\TagRepository;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;

class TagRepositoryTest extends FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/t3tags',
        'typo3conf/ext/t3tags/Tests/Functional/Fixtures/Extensions/t3tags_test',
    ];

    /**
     * @var TagRepository
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->importDataSet('ntf://Database/pages.xml');

        $fixturePath = ORIGINAL_ROOT . 'typo3conf/ext/t3tags/Tests/Functional/Fixtures/Database/';
        $this->importDataSet($fixturePath . 'pages.xml');
        $this->importDataSet($fixturePath . 'tt_content.xml');
        $this->importDataSet($fixturePath . 'tx_t3tags_tag.xml');
        $this->importDataSet($fixturePath . 'tx_t3tags_tag_mm.xml');

        $this->subject = new TagRepository();
    }

    /**
     * @test
     */
    public function findTagsByFieldReturnsAnEmptyArrayForNonTaggableField()
    {
        $this->assertSame([], $this->subject->findTagsByField('tt_content', 'tags', 1));
    }

    /**
     * @test
     */
    public function findTagsByFieldReturnsAnEmptyArrayForNonExistingRecord()
    {
        $this->assertSame([], $this->subject->findTagsByField('tt_content', 'relevant_tags', 2));
    }

    /**
     * @test
     */
    public function findTagsByFieldReturnsArrayWithTags()
    {
        $expectation = [
            1 => [
                'uid' => 1,
                'pid' => 42,
                'title' => 'magenta',
            ],
            5 => [
                'uid' => 5,
                'pid' => 42,
                'title' => 'portal magazin',
            ],
            7 => [
                'uid' => 7,
                'pid' => 42,
                'title' => 'magico',
            ],
        ];

        $this->assertArraySubset($expectation, $this->subject->findTagsByField('tt_content', 'relevant_tags', 1));
    }

    /**
     * @test
     */
    public function findTagsByRecordReturnsArrayWithFieldsAndTags()
    {
        $expectation = [
            'relevant_tags' => [
                1 => [
                    'uid' => 1,
                    'pid' => 42,
                    'title' => 'magenta',
                ],
                5 => [
                    'uid' => 5,
                    'pid' => 42,
                    'title' => 'portal magazin',
                ],
                7 => [
                    'uid' => 7,
                    'pid' => 42,
                    'title' => 'magico',
                ],
            ],
            'content_tags' => [
                3 => [
                    'uid' => 3,
                    'pid' => 42,
                    'title' => 'magie',
                ],
                10 => [
                    'uid' => 10,
                    'pid' => 42,
                    'title' => 'sprachtonalität',
                ],
            ],
        ];

        $this->assertArraySubset($expectation, $this->subject->findTagsByRecord('tt_content', 1));
    }
}
