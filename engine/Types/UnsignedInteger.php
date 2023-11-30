<?php



namespace EA\Engine\Types;

/**
 * Class UnsignedInteger
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class UnsignedInteger extends Integer {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return parent::validate($value) && $value > -1;
    }
}
