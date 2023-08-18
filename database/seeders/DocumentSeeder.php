<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Type;
use PhpParser\Comment\Doc;

class documentSeeder extends Seeder
{
    public function run()
    {

        $types = [
           [
            'id' => 1,
            'name' => 'books'
           ],
           [
            'id' => 2,
            'name' => 'officials'
           ],
           [
            'id' => 3,
            'name' => 'articles'
           ]
        ];

        $documents = [
            [
                'id' => 1,
                'name' => 'The Great Gatsby',
                'type_id' => 1,
                'values' => [
                    ['title' => 'The Great Gatsby'],
                    ['year' => 1925],
                    ['author' => 'F. Scott Fitzgerald'],
                    ['custom_books_field1' => 'Information'],
                    ['custom_books_field2' => 'Another Important Information'],
                ],
            ],
            [
                'id' => 2,
                'name' => 'To Kill a Mockingbird',
                'type_id' => 3,
                'values' => [
                    ['title' => 'To Kill a Mockingbird'],
                    ['year' => 1960],
                    ['author' => 'Harper Lee'],
                    ['custom_article_field1' => 'Information'],
                    ['custom_article_field2' => 'Another Important Information'],
                ],
            ],
            [
                'id' => 3,
                'name' => '1984',
                'type_id' => 2,
                'values' => [
                    ['title' => 'Nineteen Eighty-Four'],
                    ['year' => 1949],
                    ['author' => 'George Orwell'],
                    ['custom_officials_field1' => 'Information'],
                    ['custom_officials_field2' => 'Another Important Information'],
                ],
            ],
            [
                'id' => 4,
                'name' => 'Pride and Prejudice',
                'type_id' => 1,
                'values' => [
                    ['title' => 'Pride and Prejudice'],
                    ['year' => 1813],
                    ['author' => 'Jane Austen'],
                    ['custom_books_field1' => 'Information'],
                    ['custom_books_field2' => 'Another Important Information'],
                ],
            ],
            [
                'id' => 5,
                'name' => 'The Catcher in the Rye',
                'type_id' => 2,
                'values' => [
                    ['title' => 'The Catcher in the Rye'],
                    ['year' => 1951],
                    ['author' => 'J.D. Salinger'],
                    ['custom_officials_field1' => 'Information'],
                    ['custom_officials_field2' => 'Another Important Information'],
                ],
            ],
        ];

        foreach ($types as $type) {
            $type = new Type([
                'id' => $type['id'],
                'name' => $type['name'],
            ]);
            $type->save();

        }

        foreach ($documents as $document) {
            $document = new Document([
                'id' => $document['id'],
                'name' => $document['name'],
                'type_id' => $document['type_id'],
                'values' => $document['values']
            ]);
            $document->save();

        }
    }
}
