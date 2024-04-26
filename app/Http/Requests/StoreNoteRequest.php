<?php

namespace App\Http\Requests;

use App\Service\OpenAIService;
use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    protected OpenAIService $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        parent::__construct();
        $this->openAIService = $openAIService;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required_without:content|nullable|max:70',
            'content' => 'required_without:title|nullable|max:10000',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:255',
            'tagsInput' => 'nullable|string|max:255',
            'is_title_by_ai' => 'boolean',
            'is_content_by_ai' => 'boolean',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->filled('title') && $this->filled('content')) {
            $this->merge([
                'title' => $this->openAIService->getNoteTitle($this->content),
                'is_title_by_ai' => true,
            ]);
        }

        if (!$this->filled('content') && $this->filled('title')) {
            $this->merge([
                'content' => $this->openAIService->getNoteContent($this->content),
                'is_content_by_ai' => true,
            ]);
        }
    }
}
