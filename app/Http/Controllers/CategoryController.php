```php id="0hh6j4"
<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Api\BaseController;
use Exception;

class CategoryController extends BaseController
{
    protected CategoryService $svc;

    public function __construct(CategoryService $svc)
    {
        $this->svc = $svc;
    }

    public function index()
    {
        return $this->success(
            $this->svc->all(),
            'Berhasil menarik semua data Kategori'
        );
    }

    public function store(StoreCategoryRequest $req)
    {
        $cat = $this->svc->create($req->validated());

        return $this->success(
            $cat,
            'Kategori berhasil dibuat',
            201
        );
    }

    public function show($id)
    {
        try {

            $cat = $this->svc->find((int) $id);

            return $this->success(
                $cat,
                'Berhasil menarik satu data kategori'
            );

        } catch (Exception $e) {

            return $this->error(
                $e->getMessage(),
                404
            );
        }
    }

    public function update(UpdateCategoryRequest $req, $id)
    {
        $cat = $this->svc->update((int) $id, $req->validated());

        return $this->success(
            $cat,
            'Kategori berhasil diperbarui'
        );
    }

    public function destroy($id)
    {
        $this->svc->delete((int) $id);

        return $this->success(
            null,
            'Kategori berhasil dihapus',
            204
        );
    }
}