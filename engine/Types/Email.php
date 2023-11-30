<?php



namespace EA\Engine\Types;

/**
 * Class Email
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class Email extends NonEmptyText {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return parent::validate($value) && filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
