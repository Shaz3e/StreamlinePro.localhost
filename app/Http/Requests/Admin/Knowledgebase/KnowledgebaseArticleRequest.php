<?php

namespace App\Http\Requests\Admin\Knowledgebase;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class KnowledgebaseArticleRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_service' => [
                'nullable',
                Rule::exists('products_services', 'id'),
            ],
            'category_id' => [
                'nullable',
                'exists:knowledgebase_categories,id',
            ],
            'author_id' => [
                'nullable',
                Rule::exists('admins', 'id'),
            ],
            'title' => [
                'required',
                'max:255',
            ],
            'slug' => [
                'required',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('knowledgebase_categories', 'slug')->ignore($this->article),
            ],
            'content' => [
                'required',
            ],
            'is_published' => [
                'required',
                'boolean',
            ],
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
        ];
    }
}
