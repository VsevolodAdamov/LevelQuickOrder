<?php
namespace Level\QuickOrder\UI\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;

class ActionsSelect implements OptionSourceInterface
{
    public function toOptionArray()
    {

        return [
            ['value' => 1, 'label' => __('True')],
            ['value' => 0, 'label' => __('False')]
        ];
    }
}

