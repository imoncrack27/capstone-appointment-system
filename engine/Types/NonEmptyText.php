<?php



namespace EA\Engine\Types;

/**
 * Class NonEmptyText
 *
 * @deprecated
 *
 * @package EA\Engine\Types
 */
class NonEmptyText extends Text {
    /**
     * @param mixed $value
     * @return bool
     */
    protected function validate($value)
    {
        return parent::validate($value) && $value !== '';
    }
}
