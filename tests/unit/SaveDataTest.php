<?php
namespace tests\unit;

use app\models\MainTable;
use PHPUnit\Framework\TestCase;


class SaveDataTest extends TestCase
{
    /*public function testTrue()
    {
        $this->assertTrue(true);
    }*/


    public function testSave()
    {
        //$main_table = new MainTable();
        $post = [
            'json' => [
                'email' => '',
                'fio' => '',
                'rangeList' => '',
            ]
        ];

        $this->assertEmpty($post);
        return $post;

        //$this->assertTrue($main_table->load($post), 'Load POST data');
        //$this->assertTrue($main_table->saveData(), 'Save data');
    }

    /*public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }*/

}