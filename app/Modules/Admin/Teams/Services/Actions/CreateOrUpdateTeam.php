<?php

namespace App\Modules\Admin\Teams\Services\Actions;

use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

readonly class CreateOrUpdateTeam
{
    public function __construct(
        public ?int                     $id,
        public string                   $name,
        public ?string                  $abbreviation,
        public string|UploadedFile|null $logo,
        public ?string                  $country,
        public ?string                  $league,
    )
    {
    }

    public function execute(): array
    {
        try {
            DB::beginTransaction();

            $exist = Team::query()
                ->where('name', trim($this->name))
                ->when($this->id, fn($query) => $query->where('id', '<>', $this->id))
                ->first();

            if ($exist) {
                return ["success" => false, "msg" => "Já existe um time com esse nome."];
            }

            if ($this->id) {
                $team = Team::query()->find($this->id);
            } else {
                $team = new Team();
            }

            $team->fill([
                "name" => trim($this->name),
                "abbreviation" => $this->abbreviation ? trim($this->abbreviation) : null,
                "country" => $this->country,
                "league" => $this->league
            ]);


            if ($this->logo) {
                $logoPath = 'teams/' . $team->name . '/logo.png';
                if (Storage::disk('s3')->put($logoPath, fopen($this->logo, 'r'))) {
                    $team->logo = env('S3_URL') . $logoPath;
                }
            }

            $team->save();

            DB::commit();

            return ["success" => true, "msg" => ""];

        } catch (Exception $exception) {
            Log::error("Erro ao salvar time: " . $exception->getMessage());
            DB::rollBack();

            return ["success" => false, "msg" => "Erro ao salvar time."];
        }
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get("id"),
            $request->get("name"),
            $request->get("abbreviation"),
            $request->file("logo"),
            $request->get("country"),
            $request->get("league")
        );
    }
}
