<?php

namespace App\Modules\Admin\Category\Services\Actions;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

readonly class CreateOrUpdateCategory
{
    public function __construct(
        public ?int   $id,
        public string $name,
    )
    {
    }

    public function execute(): array
    {
        try {
            DB::beginTransaction();

            $exist = Category::query()
                ->where('name', trim($this->name))
                ->when($this->id, fn($query) => $query->where('id', '<>', $this->id))
                ->first();

            if ($exist) {
                return ["success" => false, "msg" => "Já existe uma categoria com esse nome."];
            }

            if ($this->id) {
                $category = Category::query()->find($this->id);
            } else {
                $category = new Category();
            }

            $category->fill([
                "name" => trim($this->name)
            ]);

            $category->save();

            DB::commit();

            return ["success" => true, "msg" => ""];

        } catch (Exception $exception) {
            Log::error("Erro ao salvar categoria: " . $exception->getMessage());
            DB::rollBack();

            return ["success" => false, "msg" => "Erro ao salvar categoria."];
        }
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get("id"),
            $request->get("name")
        );
    }
}
