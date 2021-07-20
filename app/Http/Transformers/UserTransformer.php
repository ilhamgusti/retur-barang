<?php

namespace App\Http\Transformers;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserTransformer
{

    public static function toInstance(array $input, $user = null)
    {
        if (empty($user)) {
            $user = new User();
        }

        foreach ($input as $key => $value) {
            switch ($key) {
                case "nama":
                    $user->nama = $value;
                    break;
                case "email":
                    $user->email = $value;
                    break;
                case "no_tel":
                    $user->no_tel = $value;
                    break;
                case "alamat":
                    $user->alamat = $value;
                    break;
                case "tipe":
                    $user->tipe = $value;
                    break;
                case "password":
                    $passwordValue = Hash::make($value);
                    $user->password = $passwordValue;
                    break;
            }
        }

        return $user;
    }
}
