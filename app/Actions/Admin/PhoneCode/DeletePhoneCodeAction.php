<?php

declare(strict_types=1);

namespace App\Actions\Admin\PhoneCode;

use App\Models\PhoneCountryCode;

final class DeletePhoneCodeAction
{
    public function execute(PhoneCountryCode $phoneCode): void
    {
        $phoneCode->delete();
    }
}
