<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to submit contact form
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'service' => 'nullable|string|in:feasibility,financial,technical,marketing,production,competitor,business,investment,market,other',
            'budget' => 'nullable|string|in:under-100k,100k-500k,500k-1m,1m-5m,over-5m',
            'message' => 'nullable|string|max:5000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'company' => 'اسم الشركة',
            'service' => 'نوع الخدمة',
            'budget' => 'الميزانية',
            'message' => 'تفاصيل المشروع',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'يرجى إدخال الاسم',
            'email.required' => 'يرجى إدخال البريد الإلكتروني',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح',
            'phone.required' => 'يرجى إدخال رقم الهاتف',
            'service.in' => 'نوع الخدمة المختار غير صالح',
        ];
    }
}
