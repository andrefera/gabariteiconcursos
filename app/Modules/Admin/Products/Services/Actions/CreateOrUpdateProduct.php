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
        public float                    $price,
        public ?float                   $special_price,
        public string                   $category,
        public bool                     $is_active,
        public ?int                     $team_id,
        public string|UploadedFile|null $sizes_image,
        public string                   $gender,
        public array                    $images,
        public array                    $sizes
    )
    {
    }

    public function execute(): array
    {
        try {
            DB::beginTransaction();

            if ($this->id) {
                $product = Product::query()->find($this->id);
            } else {
                $existSku = Product::query()->where('sku', $this->sku)->first();
                if ($existSku) {
                    return ["success" => false, "message" => "Sku já existe."];
                }

                $product = new Product();
            }

            if ($this->sizes_image) {
                $sizesImagePath = 'products/' . $product->id . '/sizes_image.png';
                $sizesImagePath = Storage::disk('s3')->put($sizesImagePath, fopen($this->sizes_image, 'r'));
                $product->sizes_image = Storage::disk('s3')->url($sizesImagePath);
            }

            $product->fill([
                "name" => trim($this->name),
                "sku" => strtoupper($this->sku),
                "url" => trim(strtolower($this->url)),
                "description" => $this->description ? trim($this->description) : null,
                "price" => $this->price,
                "special_price" => $this->special_price,
                "category" => $this->category,
                "is_active" => $this->is_active,
                "team_id" => $this->team_id,
                "gender" => $this->gender
            ]);

            $product->save();

            $imageIds = [];
            foreach ($this->images as $image) {
                if (isset($image["id"])) {
                    $productImage = ProductImage::query()->find($image["id"]);
                } else {
                    $productImage = new ProductImage();
                }

                $imagePath = 'products/' . $product->id . "/images/{$image["order"]}.png";
                $imagePath = Storage::disk('s3')->put($imagePath, fopen($image['file'], 'r'));
                $imageUrl = Storage::disk('s3')->url($imagePath);

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
                $imagePath = parse_url($deletedImage->url, PHP_URL_PATH);
                $imagePath = ltrim($imagePath, '/');

                if (Storage::disk('s3')->exists($imagePath)) {
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
        return new self(
            $request->get("id"),
            $request->get("name"),
            $request->get("sku"),
            $request->get("url"),
            $request->get("description"),
            $request->get("price"),
            $request->get("special_price"),
            $request->get("category"),
            $request->get("is_active"),
            $request->get("team_id"),
            $request->file("sizes_image"),
            $request->get("gender"),
            $request->get("images"),
            $request->get("sizes")
        );
    }
}
