<?php


class FormField
{
    private BaseModel $model;
    private string $attribute;
    private string $type;

    private const TYPE_TEXT = 'text';
    private const TYPE_PASSWORD = 'password';
    private const TYPE_NUMBER = 'number';

    /**
     * @param BaseModel $model
     * @param string $attribute
     */

    //new FormField($model, 'firstName');
    public function __construct(BaseModel $model, string $attribute)
    {
        $this->model = $model;
        
        $this->attribute = $attribute;
        
        $this->type = self::TYPE_TEXT;
    }

    public function __toString(): string
    {

        //get the labels from the mode, in this case $user
        // [
        //     'firstName' => 'First name',
        //     'lastName' => 'Last name',
        //     'email' => 'Email',
        //     'password' => 'Password',
        // ];

        $label = $this->model->getLabel($this->attribute);


        $type = $this->type;


        //we check if this is a second call to this page and that a previouse
        //error had been notified in this field
        $errorCSSClass = $this->model->hasError($this->attribute) ? ' is-invalid' : '';
        
        $error = $this->model->getFirstError($this->attribute);
        
        return <<< EOF
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">$label</label>
            <input type="$this->type" name="$this->attribute" value="{$this->model->{$this->attribute}}" class="form-control$errorCSSClass">
            <div class="invalid-feedback">
                $error
            </div>
        </div>
        EOF;
    }


    public function passwordField() {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function numberField() {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

}