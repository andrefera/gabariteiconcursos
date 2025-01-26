<?php

namespace App\Modules\Admin\Products\Services\Actions;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

readonly class CreateOrUpdateProduct
{
    public function __construct(
        public ?int                     $id,
        public string                   $name,
        public string                   $sku,
        public string                   $url,
        public ?string                  $description,
        public float                    $cost,
        public float                    $price,
        public ?float                   $special_price,
        public string                   $category,
        public bool                     $is_active,
        public ?int                     $team_id,
        public string|UploadedFile|null $sizes_image,
        public string                   $gender,
        public ?string                  $season,
        public array                    $images,
        public array                    $sizes
    )
    {
    }

    public function execute(): array
    {
        try {
            DB::beginTransaction();

            $existSku = Product::query()
                ->where('sku', $this->sku)
                ->when($this->id, fn($query) => $query->where('id', '<>', $this->id))
                ->first();

            if ($existSku) {
                return ["success" => false, "msg" => "Sku já existe."];
            }

            $existUrl = Product::query()
                ->where('url', trim(strtolower($this->url)))
                ->when($this->id, fn($query) => $query->where('id', '<>', $this->id))
                ->first();

            if ($existUrl) {
                return ["success" => false, "msg" => "Url já existe."];
            }

            if ($this->id) {
                $product = Product::query()->find($this->id);
            } else {
                $product = new Product();
            }

            $product->fill([
                "name" => trim($this->name),
                "sku" => strtoupper($this->sku),
                "url" => trim(strtolower($this->url)),
                "description" => $this->description ? trim($this->description) : null,
                "cost" => $this->cost,
                "price" => $this->price,
                "special_price" => $this->special_price,
                "category" => $this->category,
                "is_active" => $this->is_active,
                "team_id" => $this->team_id,
                "gender" => $this->gender,
                "season" => $this->season
            ]);

            $product->save();

            if ($this->sizes_image) {
                $sizesImagePath = 'products/' . $product->id . '/sizes_image.png';
                if (Storage::disk('s3')->put($sizesImagePath, fopen($this->sizes_image, 'r'))) {
                    $product->sizes_image = env('S3_URL') . $sizesImagePath;
                    $product->save();
                }
            }

            $imageIds = [];
            foreach ($this->images as $image) {
                if (isset($image["id"])) {
                    $productImage = ProductImage::query()->find($image["id"]);
                    $imageUrl = $productImage->url;

                } else {
                    $productImage = new ProductImage();
                    $time = time();
                    $imagePath = 'products/' . $product->id . "/images/image_$time.png";
                    Storage::disk('s3')->put($imagePath, fopen($image['file'], 'r'));
                    $imageUrl = env('S3_URL') . $imagePath;

                }

                $productImage->fill([
                    "product_id" => $product->id,
                    "url" => $imageUrl,
                    "order" => $image["order"]
                ]);

                $productImage->save();

                $imageIds[] = $productImage->id;
            }

            $deletedImages = ProductImage::query()->where("product_id", $product->id)->whereNotIn("id", $imageIds)->get();
            foreach ($deletedImages as $deletedImage) {
                $imagePath = str_replace(env('S3_URL'), '', $deletedImage->url);

                if (Storage::disk('s3')->exists($imagePath)) {
                    Log::warning("Deleting image: " . $deletedImage->url);
                    Storage::disk('s3')->delete($imagePath);
                }

                $deletedImage->delete();
            }

            $sizeIds = [];
            foreach ($this->sizes as $size) {
                if (isset($size["id"])) {
                    $productSize = ProductSize::query()->find($size["id"]);
                } else {
                    $productSize = new ProductSize();
                }

                $productSize->fill([
                    "product_id" => $product->id,
                    "name" => $size["name"],
                    "stock" => $size["stock"]
                ]);
                $productSize->save();

                $sizeIds[] = $productSize->id;
            }
            ProductSize::query()->where("product_id", $product->id)->whereNotIn("id", $sizeIds)->delete();

            DB::commit();

            return ["success" => true, "msg" => ""];

        } catch (Exception $exception) {
            Log::error("Erro ao salvar produto: " . $exception->getMessage());
            DB::rollBack();

            return ["success" => false, "msg" => "Erro ao salvar produto."];
        }
    }

    public static function fromRequest(Request $request): self
    {
        $images = [];
        $position = 1;
        do {
            $file = $request->file('image_file_' . $position);
            $id = $request->get('image_id_' . $position);

            if ($file || $id) {
                $images[] = [
                    'id' => $id,
                    'order' => (int)$request->get('image_order_' . $position),
                    'file' => $file
                ];

                $position++;
            }
        } while ($file !== null || $id !== null);

        $sizes = [];
        $position = 1;

        do {
            $name = $request->get('size_name_' . $position);
            if ($name) {
                $sizes[] = [
                    'id' => $request->get('size_id_' . $position),
                    'name' => $name,
                    'stock' => (int)$request->get('size_stock_' . $position)
                ];

                $position++;
            }
        } while ($name !== null);

        return new self(
            $request->get("id"),
            $request->get("name"),
            $request->get("sku"),
            $request->get("url"),
            $request->get("description"),
            floatval($request->get('cost')),
            floatval($request->get('price')),
            $request->get("special_price") ? $request->get("special_price") : null,
            $request->get("category"),
            $request->get("is_active") == '1',
            $request->get("team_id") ? (int)$request->get("team_id") : null,
            $request->file("sizes_image"),
            $request->get("gender"),
            $request->get("season"),
            $images,
            $sizes
        );
    }
}
