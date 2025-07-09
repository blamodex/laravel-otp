<?php

namespace Blamodex\Otp\Validators;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\MessageBag;

/**
 * Validates a one-time password (OTP) string against configured length and alphabet.
 */
class OtpValidator
{
    /**
     * The input OTP string to validate.
     *
     * @var string
     */
    protected string $input;

    /**
     * Expected OTP length from config.
     *
     * @var int
     */
    protected int $length;

    /**
     * Allowed OTP alphabet from config.
     *
     * @var string
     */
    protected string $alphabet;

    /**
     * Validation errors container.
     *
     * @var MessageBag
     */
    protected MessageBag $errors;

    /**
     * Constructor.
     *
     * @param string $input The OTP input string to validate.
     */
    public function __construct(string $input)
    {
        $this->input = $input;
        $this->length = Config::get('blamodex.otp.length');
        $this->alphabet = Config::get('blamodex.otp.alphabet');
        $this->errors = new MessageBag();
    }

    /**
     * Perform the validation.
     *
     * @return bool True if valid; false otherwise.
     */
    public function passes(): bool
    {
        $isValid = true;

        if (strlen($this->input) !== $this->length) {
            $this->errors->add('otp', "OTP must be exactly {$this->length} characters long.");
            $isValid = false;
        }

        $pattern = '/^[' . preg_quote($this->alphabet, '/') . ']+$/';

        if (!preg_match($pattern, $this->input)) {
            $this->errors->add('otp', "OTP contains invalid characters.");
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * Get the validation errors.
     *
     * @return MessageBag A collection of validation error messages.
     */
    public function errors(): MessageBag
    {
        return $this->errors;
    }
}