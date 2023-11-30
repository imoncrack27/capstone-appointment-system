<?php



namespace EA\Engine\Types;

/**
 * Class Boolean
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class Boolean extends Type {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return is_bool($value);
    }
}
