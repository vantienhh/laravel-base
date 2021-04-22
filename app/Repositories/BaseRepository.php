<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use ReflectionClass;
use \Carbon\Carbon;
use App\Contracts\Base\BaseRepositoryInterface;


abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model          $model;
    private ?ReflectionClass $reflection = null;

    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    protected function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function getModel(): Model|Builder
    {
        return $this->model;
    }

    protected function getReflection(): ReflectionClass
    {
        return $this->reflection ?? new ReflectionClass($this->getModel());
    }

    /**
     * Lấy thông tin 1 bản ghi xác định bởi ID
     *
     * @throws ModelNotFoundException
     */
    public function getById(mixed $id): Model|Collection
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Lấy thông tin 1 bản ghi đã bị xóa softDelete được xác định bởi ID
     *
     * @param mixed $id
     * @return Model|Collection|$this
     *
     * @throws ModelNotFoundException
     */
    public function getByIdInTrash(mixed $id): Model|Collection|static
    {
        return $this->getModel()->withTrashed()->findOrFail($id);
    }

    public function getByQuery(array $params = [], int $size = 20)
    {
        $model  = $this->getModel();
        $params = Arr::except($params, ['page', 'limit']);

        count($params) && $model = $this->applyLocalScopeFilter($model, $params);

        return match ($size) {
            -1 => $model->get(),
            0 => $model->first(),
            default => $model->paginate($size),
        };
    }

    protected function applyLocalScopeFilter(Model $model, array $params): Model|Builder
    {
        foreach ($params as $funcName => $funcParams) {
            $funcName            = Str::studly($funcName);
            $hasMethodLocalScope = $this->getReflection()->hasMethod('scope' . $funcName);

            if ($hasMethodLocalScope && $funcParams) {
                $funcName = lcfirst($funcName);
                $model    = $model->$funcName($funcParams);
            }
        }
        return $model;
    }

    public function store(array $params): Model|static
    {
        $fillable = $this->getModel()->getFillable();

        return $this->getModel()->create(Arr::only($params, $fillable));
    }

    public function storeArray(array $listData): bool
    {
        if (count($listData) && is_array(reset($listData))) {
            $fillable       = $this->getModel()->getFillable();
            $usesTimestamps = $this->getModel()->usesTimestamps();
            $now            = Carbon::now();

            foreach ($listData as $key => $data) {
                $listData[$key] = Arr::only($data, $fillable);
                if ($usesTimestamps) {
                    $listData[$key]['created_at'] = $now;
                    $listData[$key]['updated_at'] = $now;
                }
            }
            return $this->getModel()->insert($listData);
        }

        $this->store($listData);
        return true;
    }

    public function update(mixed $id, array $data, array $excepts = [], array $only = []): Model|Collection|static
    {
        count($excepts) && $data = Arr::except($data, $excepts);
        count($only) && $data = Arr::only($data, $only);

        $record = $this->getById($id);
        $record->fill($data)->save();

        return $record;
    }

    /**
     * Xóa 1 bản ghi. Nếu model xác định 1 SoftDeletes
     * thì method này chỉ đưa bản ghi vào trash. Dùng method destroy
     * để xóa hoàn toàn bản ghi.
     *
     * @param mixed $id
     * @return bool|null
     * @throws \Exception
     */
    public function delete(mixed $id): bool|null
    {
        $record = $this->getById($id);

        return $record->delete();
    }

    /**
     * Xóa hoàn toàn một bản ghi
     *
     * @param  mixed $id ID bản ghi
     * @return bool|null
     */
    public function destroy(mixed $id): bool|null
    {
        $record = $this->getById($id);
        return $record->forceDelete();
    }

    /**
     * Khôi phục 1 bản ghi SoftDeletes đã xóa
     *
     * @param  mixed $id ID bản ghi
     * @return bool|null
     */
    public function restore(mixed$id): bool|null
    {
        $record = $this->getById($id);

        return $record->restore();
    }
}
