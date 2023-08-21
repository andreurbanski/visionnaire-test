<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\DocumentController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Requests\RequestDocumentUpdate;
use App\Http\Requests\RequestDocumentStore;
use App\Models\Document;
use App\Models\Type;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    
    /**
    * Test the Index action
    */
    /** @test */
    public function test_index_html(): void
    {
        $controller = new DocumentController();
        $request = new Request();
        $response = $controller->index($request);

        $this->assertStringContainsString('List of Documents', $response);
    }

    /**
     * Test the Ajax Create action
     */
    /** @test */
    public function test_store(): void
    {
        $this->set_database();

        $json = [
            "name" => "TEST",
            "type_id" => 1,
            "values" => [
                ["title" => "this is A TEST"],
                ["year" => 2023],
                ["author" => "THIS IS A TEST"]
            ]
        ];

        $controller = new DocumentController();

        $response = $controller->store(new RequestDocumentStore($json));

        $this->assertDatabaseHas('documents', ['name' => 'TEST']);
    }

    /**
     * Test the Ajax Create action
     */
    /** @test */
    public function test_store_missing_fields(): void
    {
        $this->set_database();

        $json = [
                "name" => 'MISSING VALUES ARRAY'
        ];

        $controller = new DocumentController();

        $response = $controller->store(new RequestDocumentStore($json));

        $this->assertTrue($response->status() == 500);
    }

    /**
     * Test the Ajax Update action
     */
    /** @test */
    public function test_update(): void
    {
        $this->set_database();

        $json = [
            "name" => "TEST",
            "type_id" => 1,
            "values" => [
                ["title" => "this is A TEST"],
                ["year" => 2023],
                ["author" => "THIS IS A TEST"]
            ]
        ];

        $controller = new DocumentController();

        $response = $controller->store(new RequestDocumentStore($json));

        $json = [
            "id"  => $response->getData()->id,
            "name" => "MODIFIED",
            "type_id" => 1,
            "values" => [
                ["title" => "MODIFIED"],
                ["year" => 2023],
                ["author" => "MODIFIED"]
            ]
        ];

        $response = $controller->update(new RequestDocumentUpdate($json));

        $this->assertDatabaseHas('documents', ['name' => 'MODIFIED']);
    }

     /**
     * Test the Ajax Update Not found action
     */
    /** @test */
    public function test_update_not_exists(): void
    {
        $controller = new DocumentController();

        $response = $controller->update(new RequestDocumentUpdate());

        $this->assertTrue($response->status() == 404);
    }

    /**
     * Test the Ajax Delete action
     */
    /** @test */
    public function test_delete(): void
    {
        $this->set_database();

        $json = [
            "name" => "TEST",
            "type_id" => 1,
            "values" => [
                ["title" => "this is A TEST"],
                ["year" => 2023],
                ["author" => "THIS IS A TEST"]
            ]
        ];

        $controller = new DocumentController();

        $response = $controller->store(new RequestDocumentStore($json));

        $response = $controller->destroy(new Request(), id:$response->getData()->id);

        $this->assertDatabaseMissing('documents', ['name' => 'DELETE']);
    }

    /**
     * Test the Ajax delete not found action
     */
    /** @test */
    public function test_delete_not_exists(): void
    {

        $controller = new DocumentController();

        $response = $controller->destroy(new Request(), id:1);

        $this->assertTrue($response->status() == 404);
    }

     /**
     * Test the Ajax Show action
     */
    /** @test */
    public function test_show_exists(): void
    {
        $this->set_database();

        $json = [
            "name" => "SHOW",
            "type_id" => 1,
            "values" => [
                ["title" => "SHOW"],
                ["year" => 2023],
                ["author" => "SHOW"]
            ]
        ];

        $controller = new DocumentController();

        $response = $controller->store(new RequestDocumentStore($json));

        $response_show = $controller->show(new Request(), id:$response->getData()->id );


        $this->assertTrue($response_show->status() == 200);
    }

     /**
     * Test the Ajax Show not found action for 404
     */
    /** @test */
    public function test_show_not_exists(): void
    {
        $controller = new DocumentController();

        $response_show = $controller->show(new Request(), id:1 );


        $this->assertTrue($response_show->status() == 404);
    }

    /**
     * Test the Ajax Base64 PDF  action
     */
    /** @test */
    public function test_generate_pdf_ajax(): void
    {
        $this->set_database();

        $json = [
            "name" => "PDF",
            "type_id" => 1,
            "values" => [
                ["title" => "PDF"],
                ["year" => 2023],
                ["author" => "PDF"]
            ]
        ];

        $controller = new DocumentController();

        $response = $controller->store(new RequestDocumentStore($json));

        $request = new Request();
        $request->header('Accept', 'application/json');

        $response_show = $controller->generate_pdf($request, id:$response->getData()->id );


        $this->assertTrue($response_show->status() == 200);
    }

    /**
     * Test the Ajax Base64 PDF not found action
     */
    /** @test */
    public function test_generate_pdf_not_exists(): void
    {

        $controller = new DocumentController();

        $request = new Request();
        $request->header('Accept', 'application/json');

        $response_show = $controller->generate_pdf($request, id:1 );


        $this->assertTrue($response_show->status() == 404);
    }

    /**
     * Test the Web Downloadable PDF File action
     */
    /** @test */
    public function test_generate_pdf_downloadable(): void
    {
        $this->set_database();

        $json = [
            "name" => "PDF",
            "type_id" => 1,
            "values" => [
                ["title" => "PDF"],
                ["year" => 2023],
                ["author" => "PDF"]
            ]
        ];

        $controller = new DocumentController();

        $response = $controller->store(new RequestDocumentStore($json));

        $request = new Request();

        $response_show = $controller->generate_pdf($request, id:$response->getData()->id );


        $this->assertTrue($response_show->status() == 200);
    }

    public function set_database() {

        $type = new Type();
        $type->fill([
            'id' => 1,
            'name' => 'books'
           ],
        );
        $type->save();

        $document = new Document();
        $document->fill([
            "name" => "TEST",
            "type_id" => 1,
            "values" => [
                ["title" => "TEST"],
                ["year" => 2023],
                ["author" => "TEST"]
            ]
            ]);

        $document->save();
    }
}
