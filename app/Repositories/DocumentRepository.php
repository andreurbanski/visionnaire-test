<?php

namespace App\Repositories;

use App\Models\Document;

class DocumentRepository
{
    public function getById($id)
    {
        return Document::find($id);
    }

    public function getAll()
    {
        return Document::all();
    }
}
