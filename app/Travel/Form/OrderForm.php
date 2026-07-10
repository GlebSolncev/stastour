<?php

namespace App\Travel\Form;

class OrderForm
{
    public ?string $name = null;
    public ?string $phone = null;
    public ?string $email = null;

    public ?string $restrictions = null;
    public ?string $comments = null;

    public static function fromRequest(): OrderForm
    {
        $form = new OrderForm();

        if($value = request()->post('name')) {
            $form->name = $value;
        }
        if($value = request()->post('phone')) {
            $form->phone = $value;
        }
        if($value = request()->post('email')) {
            $form->email = $value;
        }

        if($value = request()->post('restrictions')) {
            $form->restrictions = $value;
        }
        if($value = request()->post('comments')) {
            $form->comments = $value;
        }

        return $form;
    }

    public function toArray() {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'restrictions' => $this->restrictions,
            'comments' => $this->comments,
        ];
    }
}
