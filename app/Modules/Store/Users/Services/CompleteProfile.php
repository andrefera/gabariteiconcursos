<?php

namespace App\Modules\Store\Users\Services;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

readonly class CompleteProfile
{
    public function __construct(
        private string $document,
        private string $phone,
        private array $address,
        private bool $useAsShipping = false
    ) {}

    public function execute(): array
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            $document = preg_replace('/[^0-9]/', '', $this->document);
            $phone = preg_replace('/[^0-9]/', '', $this->phone);

            $user->update([
                'document' => $document,
                'phone' => $phone,
                'zip_code' => $this->address['zipcode'],
                'city' => $this->address['city'],
                'state' => $this->address['state'],
                'street_name' => $this->address['street'],
                'street_neighborhood' => $this->address['neighborhood'],
                'street_number' => $this->address['number'],
                'street_complement' => $this->address['complement'] ?? null,
            ]);


            if ($this->useAsShipping) {
                $userAddress = UserAddress::query()
                    ->where('zip_code', $this->address['zipcode'])
                    ->where('street', $this->address['street'])
                    ->where('neighborhood', $this->address['neighborhood'])
                    ->where('number', $this->address['number'])
                    ->where('city', $this->address['city'])
                    ->where('state', $this->address['state'])
                    ->first();

                if (!$userAddress) {
                    $userAddress = UserAddress::create([
                        'user_id' => $user->id,
                        'street' => $this->address['street'],
                        'neighborhood' => $this->address['neighborhood'],
                        'number' => $this->address['number'],
                        'city' => $this->address['city'],
                        'state' => $this->address['state'],
                        'zip_code' => $this->address['zipcode'],
                        'complement' => $this->address['complement'] ?? null,
                        'is_default' => true
                    ]);
                }

                $user->addresses()
                    ->where('id', '!=', $userAddress->id)
                    ->update(['is_default' => false]);
            }

            return [
                'success' => true,
                'message' => 'Perfil atualizado com sucesso!'
            ];
        } catch (\Exception $e) {
            report($e);
            return [
                'success' => false,
                'message' => 'Erro ao atualizar perfil. Por favor, tente novamente.'
            ];
        }
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            document: $request->get('document'),
            phone: $request->get('phone'),
            address: $request->get('billing_address'),
            useAsShipping: $request->boolean('use_as_shipping', false)
        );
    }
}
