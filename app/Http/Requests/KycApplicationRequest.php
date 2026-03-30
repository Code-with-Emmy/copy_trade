<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KycApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $maxUploadKb = $this->maxUploadKilobytes();

        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'document_type' => 'required',
            'frontimg' => "required|file|mimes:jpeg,jpg,png,pdf|max:{$maxUploadKb}",
            'backimg' => "required|file|mimes:jpeg,jpg,png,pdf|max:{$maxUploadKb}",
            'face_img' => "required|file|mimes:jpeg,jpg,png|max:{$maxUploadKb}",
            'ssn' => 'required_if:country,USA',
        ];
    }

    public function messages()
    {
        $maxUploadMb = number_format($this->maxUploadKilobytes() / 1024, 1);

        return [
            'frontimg.required' => 'Please upload the front image of your ID document.',
            'backimg.required' => 'Please upload the back image of your ID document.',
            'face_img.required' => 'Please upload a selfie photo.',
            'frontimg.mimes' => 'Front document must be a JPEG, JPG, PNG, or PDF file.',
            'backimg.mimes' => 'Back document must be a JPEG, JPG, PNG, or PDF file.',
            'face_img.mimes' => 'Selfie must be a JPEG, JPG, or PNG file.',
            'frontimg.max' => "Front document must not exceed {$maxUploadMb}MB.",
            'backimg.max' => "Back document must not exceed {$maxUploadMb}MB.",
            'face_img.max' => "Selfie must not exceed {$maxUploadMb}MB.",
            'frontimg.uploaded' => "Front document failed to upload. The server currently allows up to {$maxUploadMb}MB per file.",
            'backimg.uploaded' => "Back document failed to upload. The server currently allows up to {$maxUploadMb}MB per file.",
            'face_img.uploaded' => "Selfie failed to upload. The server currently allows up to {$maxUploadMb}MB per file.",
        ];
    }

    private function maxUploadKilobytes(): int
    {
        $uploadMaxKb = $this->iniSizeToKilobytes((string) ini_get('upload_max_filesize'));
        $postMaxKb = $this->iniSizeToKilobytes((string) ini_get('post_max_size'));

        $effectiveMaxKb = min(array_filter([$uploadMaxKb, $postMaxKb])) ?: 2048;

        // keep a small buffer below hard php.ini limits
        return max(256, $effectiveMaxKb - 64);
    }

    private function iniSizeToKilobytes(string $size): int
    {
        $size = trim($size);
        if ($size === '') {
            return 0;
        }

        $unit = strtolower(substr($size, -1));
        $value = is_numeric($unit) ? (float) $size : (float) substr($size, 0, -1);

        return match ($unit) {
            'g' => (int) ($value * 1024 * 1024),
            'm' => (int) ($value * 1024),
            'k' => (int) $value,
            default => (int) ($value / 1024),
        };
    }
}
