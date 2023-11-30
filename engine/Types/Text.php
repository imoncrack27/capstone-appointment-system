<?php



namespace EA\Engine\Types;

/**
 * Class Text
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class Text extends Type {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return is_string($value);
    }
}
