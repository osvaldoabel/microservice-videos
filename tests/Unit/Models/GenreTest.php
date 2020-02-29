<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenreTest extends TestCase
{
    private $genre;

    public static function setUpBeforeClass() : void
    {
        // global things for this test class.
        // executed once befor any methods (tests)
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->genre = new Genre();
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
        $genre = $this->genre;
        $fillable = ['name', 'is_active'];

        $this->assertEquals($fillable, $genre->getFillable());
    }

    public function testIfUseTrait()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];

        $genreTraits = array_keys(class_uses(Genre::class));

        $this->assertEquals($traits, $genreTraits);
    }

    public function testCasts()
    {
        $casts = ['id' => 'string', 'is_active' => 'boolean'];
        $genre = $this->genre;

        $this->assertEquals($casts, $genre->getCasts());
    }

    public function testIncrementing()
    {
        $genre = $this->genre;
        $this->assertFalse($genre->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'updated_at', 'created_at'];
        $genre = $this->genre;

        $genreDateFields = $genre->getDates();

        sort($genreDateFields);
        sort($dates);

        $this->assertEquals($dates, $genreDateFields);
        $this->assertCount(count($dates), $genreDateFields); //nem precisaria
    }
}
