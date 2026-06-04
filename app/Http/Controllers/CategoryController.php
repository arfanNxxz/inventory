<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected CategoryService $svc;

    public function __construct(CategoryService $svc)
    {
        $this->svc = $svc;
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->svc->all(),
            'message' => 'Berhasil menarik semua data Kategori',
        ]);
    }

    public function store(StoreCategoryRequest $req)
    {
        $cat = $this->svc->create($req->validated());

        return response()->json([
            'status' => 'success',
            'data' => $cat,
            'message' => 'Kategori berhasil dibuat',
        ], 201);
    }

    public function show($id)
    {
        try {
            $cat = $this->svc->find((int) $id);

            return response()->json([
                'status' => 'success',
                'data' => $cat,
                'message' => 'Berhasil menarik satu data kategori',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(UpdateCategoryRequest $req, $id)
    {
        $cat = $this->svc->update((int) $id, $req->validated());

        return response()->json([
            'status' => 'success',
            'data' => $cat,
            'message' => 'Kategori berhasil diperbarui',
        ]);
    }

    public function destroy($id)
    {
        $this->svc->delete((int) $id);

        return response()->json(null, 204);
    }
}