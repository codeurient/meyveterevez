<?php

declare(strict_types=1);

namespace App\Actions\Admin\PhoneCode;

use App\DTOs\Admin\PhoneCodeDTO;
use App\Models\PhoneCountryCode;

final class UpdatePhoneCodeAction
{
    public function execute(PhoneCountryCode $phoneCode, PhoneCodeDTO $dto): PhoneCountryCode
    {
        $phoneCode->update([
            'name'         => $dto->name,
            'native_name'  => $dto->nativeName,
            'phone_code'   => $dto->phoneCode,
            'trunk_prefix' => $dto->trunkPrefix,
            'idd_prefix'   => $dto->iddPrefix,
            'is_active'    => $dto->isActive,
        ]);

        return $phoneCode->refresh();
    }
}
