<?php



namespace EA\Engine\Types;

/**
 * Class Url
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class Url extends NonEmptyText {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return parent::validate($value) && filter_var($value, FILTER_VALIDATE_URL);
    }
}
