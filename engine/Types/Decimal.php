<?php



namespace EA\Engine\Types;


/**
 * Class Decimal
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class Decimal extends Type {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return is_float($value);
    }
}
