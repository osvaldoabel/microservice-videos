<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    private $category;

    public static function setUpBeforeClass() : void
    {
        // global things for this test class.
        // executed once befor any methods (tests)
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->category = new Category();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass() : void
    {
        parent::tearDownAfterClass();
        //executed once, after every methods executed
    }

    public function testFillable()
    {
        $category = $this->category;
        $fillable = ['name', 'description', 'is_active'];

        $this->assertEquals($fillable, $category->getFillable());
    }

    public function testIfUseTrait()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];

        $categoryTraits = array_keys(class_uses(Category::class));

        $this->assertEquals($traits, $categoryTraits);
    }

    public function testCasts()
    {
        $casts = ['id' => 'string', 'is_active' => 'boolean'];
        $category = $this->category;

        $this->assertEquals($casts, $category->getCasts());
    }

    public function testIncrementing()
    {
        $category = $this->category;
        $this->assertFalse($category->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'updated_at', 'created_at'];
        $category = $this->category;

        $categoryDateFields = $category->getDates();

        sort($categoryDateFields);
        sort($dates);

        $this->assertEquals($dates, $categoryDateFields);
        $this->assertCount(count($dates), $categoryDateFields); //nem precisaria
    }
}
