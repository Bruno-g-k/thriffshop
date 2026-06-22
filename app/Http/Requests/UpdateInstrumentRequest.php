<?php

// app/Http/Requests/UpdateInstrumentRequest.php

namespace App\Http\Requests;

use App\Models\Instrument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInstrumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // A Policy verifica a propriedade; aqui só confirma autenticação
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price'       => ['required', 'numeric', 'min:1', 'max:9999999.99'],
            'brand'       => ['required', 'string', 'max:100'],
            'condition'   => ['required', Rule::in(Instrument::CONDITIONS)],
            'status'      => ['required', Rule::in([Instrument::STATUS_ACTIVE, Instrument::STATUS_SOLD])],
            'categories'  => ['nullable', 'array'],
            'categories.*'=> ['integer', 'exists:categories,id'],
            'images'      => ['nullable', 'array', 'max:10'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'cover_index' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'condition.in' => 'A condição deve ser Mint Riff, Good Riff ou Heavy Riff.',
        ];
    }
}
