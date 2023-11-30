<?php



namespace EA\Engine\Types;

/**
 * Class Integer
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class Integer extends Type {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return is_numeric($value) && ! is_float($value);
    }
}
