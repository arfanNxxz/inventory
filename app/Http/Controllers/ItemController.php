<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use App\Http\Controllers\Api\BaseController;
use Exception;
use Illuminate\Http\JsonResponse;

class ItemController extends BaseController
{
    protected ItemService $svc;

    // Inject ItemService melalui Constructor
    public function __construct(ItemService $svc)
    {
        $this->svc = $svc;
    }

    public function index(): JsonResponse
    {
        return $this->success(
            $this->svc->all(),
            'Berhasil menarik semua data Item'
        );
    }

    public function store(StoreItemRequest $req): JsonResponse
    {
        $item = $this->svc->create($req->validated());

        return $this->success(
            $item,
            'Item berhasil dibuat',
            201
        );
    }

    public function show($id): JsonResponse
    {
        try {

            $item = $this->svc->find($id);

            return $this->success(
                $item,
                'Berhasil menarik satu data Item'
            );

        } catch (Exception $e) {

            return $this->error(
                $e->getMessage(),
                404
            );
        }
    }

    public function update(UpdateItemRequest $req, $id): JsonResponse
    {
        $item = $this->svc->update($id, $req->validated());

        return $this->success(
            $item,
            'Item berhasil diperbarui'
        );
    }

    public function destroy($id): JsonResponse
    {
        $this->svc->delete($id);

        return $this->success(
            null,
            'Item berhasil dihapus',
            204
        );
    }
}

