<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->updateImage != "false"){
            return [
                'name' => 'required',
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                'priority' => 'required',
                'enable' => 'required',
            ];
        }else {
            return [
                'name' => 'required',
                'priority' => 'required',
                'enable' => 'required',
            ];
        }
    }
}
