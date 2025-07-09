<?php

namespace Blamodex\Otp\Contracts;

/**
 * Interface OneTimePasswordableInterface
 *
 * Represents a model that can be assigned a one-time password (OTP).
 */
interface OneTimePasswordableInterface
{
    /**
     * Get the unique identifier for the model.
     *
     * Typically the primary key.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get the morph class name for the model.
     *
     * Used in polymorphic relationships.
     *
     * @return string
     */
    public function getMorphClass();
}
