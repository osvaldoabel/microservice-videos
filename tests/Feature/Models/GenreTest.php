<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenreTest extends TestCase
{

    use DatabaseMigrations;

    public function testList()
    {
        $genres = Genre::all();
        $this->assertCount(1, $genres);

        $currentFields =
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ];

        $keys = array_keys($genres->first()->getAttributes());

        $this->assertEqualsCanonicalizing($currentFields, $keys);
    }


    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);

        $genre->refresh();

        $this->assertEquals(36, strlen($genre->id));
        $this->assertEquals('test1', $genre->name);
        $this->assertNull($genre->description);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'description' => null
        ]);
        $this->assertNull($genre->description);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'name 01',
            'is_active' => false
        ])->first();

        $data = [
            'name' => 'updated name 01',
            'is_active'   => true
        ];

        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();
        $genre->delete();
        $this->assertNull(Genre::find($genre->id));
        $genre->restore();
        $this->assertNotNull(Genre::find($genre->id));
    }
}
