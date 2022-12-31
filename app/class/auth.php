<?php

class Auth
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $detail) {
            $this->$key = $detail;
        }
    }

    public function checkSiginUpEmpty()
    {
        if (
            empty($this->firstname) ||
            empty($this->lastname) ||
            empty($this->email) ||
            empty($this->gender) ||
            empty($this->phonenumber) ||
            empty($this->username) ||
            empty($this->password1) ||
            empty($this->password2)
        ) {
            return true;
        }
    }

    public function checkUpdateEmpty()
    {
        if (
            empty($this->firstname) ||
            empty($this->lastname) ||
            empty($this->email) ||
            empty($this->phonenumber) ||
            empty($this->username)
        ) {
            return true;
        }
    }

    public function checkSiginInEmpty()
    {
        if (empty($this->username) || empty($this->password)) {
            return true;
        }
    }

    public function validateEmail()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
    }
}
