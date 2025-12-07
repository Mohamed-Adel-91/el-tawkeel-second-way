<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use BenSampo\Enum\Rules\EnumValue;
use App\Enums\ColorTypeEnum;

class ColorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('color');
        $unique = 'unique:colors,name' . ($id ? ',' . $id : '');
        return [
            'name' => ['required', 'string', 'max:255', $unique],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5000'],
            'type' => ['required', new EnumValue(ColorTypeEnum::class, false)],
            'front_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
