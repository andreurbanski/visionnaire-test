<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestDocumentStore;
use App\Models\Document;
use App\Repositories\DocumentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Casts\Json;
use PhpParser\Node\Expr\Cast\Bool_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocumentController extends Controller
{
    var $document;
    var $repository;

    public function __construct()
    {
        // Singleton
        $this->document = new Document();
        $this->repository = new DocumentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $documents = $this->repository->getAll();

        if ($request->wantsJson())
            return ($documents);

        return view('documents', compact('documents'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestDocumentStore $request): JsonResponse
    {
        try {
            $this->document->fill($request->all());
            $this->document->save();

            return response()->json(data:$this->document);

        }  catch (Exception $e) {
            return response()->json(status:500, data:['message' => "Server Error : {$e->getMessage()}"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Int $id) : JsonResponse
    {
        try {
            $this->document = $this->repository->getById($id);

            if(empty($this->document)) {
                throw new NotFoundHttpException();
            }

            return response()->json($this->document);

        } catch (NotFoundHttpException $e) {
            return response()->json(status:404, data:['message' => "Document inexistent or not found"]);
        } catch (Exception $e) {
            return response()->json(status:500, data:['message' => 'Server Error']);
        }
    }

    /**
     * Generate a PDF for the specified resource.
     */
    public function generate_pdf(Request $request, Int $id)
    {
        try {
            $this->document = $this->repository->getById($id);

            if(empty($this->document)) {
                throw new NotFoundHttpException();
            }

            $pdf = Pdf::loadView("pdf_{$this->document->type->name}_template", ['document' => $this->document]);

            if ($request->wantsJson())
                return base64_encode( $pdf->output());

            return $pdf->download('document.pdf');

        }  catch (NotFoundHttpException $e) {
            return response()->json(status:404, data:['message' => "Document inexistent or not found"]);
        } catch (Exception $e) {
            return response()->json(status:500, data:['message' => 'Server Error']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) : JsonResponse
    {
        try {
            $this->document = $this->repository->getById($request->input('id'));
            if(empty($this->document)) {
                throw new NotFoundHttpException();
            }
            $this->document->fill($request->all());
            $this->document->save();

            return response()->json($this->document);

        }  catch (NotFoundHttpException $e) {
            return response()->json(status:404, data:['message' => "Document inexistent or not found"]);
        } catch (Exception $e) {
            return response()->json(status:500, data:['message' => 'Server Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Int $id) : JsonResponse
    {
        try {
            $this->document = $this->repository->getById($id);

            if(empty($this->document)) {
                throw new NotFoundHttpException();
            }
            $this->document->delete();

            return response()->json(['success' => true]);

        }  catch (NotFoundHttpException $e) {
            return response()->json(status:404, data:['message' => "Document inexistent or not found"]);
        } catch (Exception $e) {
            return response()->json(status:500, data:['message' => 'Server Error']);
        }
    }
}
