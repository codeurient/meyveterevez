<?php

declare(strict_types=1);

namespace App\Actions\Admin\PhoneCode;

use App\DTOs\Admin\PhoneCodeDTO;
use App\Models\PhoneCountryCode;

final class CreatePhoneCodeAction
{
    public function execute(PhoneCodeDTO $dto): PhoneCountryCode
    {
        return PhoneCountryCode::create([
            'code'         => $dto->code,
            'name'         => $dto->name,
            'native_name'  => $dto->nativeName,
            'phone_code'   => $dto->phoneCode,
            'trunk_prefix' => $dto->trunkPrefix,
            'idd_prefix'   => $dto->iddPrefix,
            'is_active'    => $dto->isActive,
        ]);
    }
}
