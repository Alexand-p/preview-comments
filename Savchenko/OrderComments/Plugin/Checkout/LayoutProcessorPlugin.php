<?php

declare(strict_types=1);

namespace Savchenko\OrderComments\Plugin\Checkout;
use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Savchenko\OrderComments\Helper\Data;

/**
 * Class LayoutProcessorPlugin
 */
class LayoutProcessorPlugin
{
    /**
     * @var Data
     */
    protected $orderComments;

    /**
     * @param Data $orderComments
     */
    public function __construct(
        Data $orderComments
    ) {
        $this->orderComments = $orderComments;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ) {
        $commentStatus = $this->orderComments->isEnabled();
        if ($commentStatus) {
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children']
            ['before-place-order']['children']
            ['Order_Comments'] = [
                'component' => 'Magento_Ui/js/form/element/textarea',
                'config' => [
                    'customScope' => 'myOrderComments',
                    'template' => 'ui/form/field',
                    'id' => 'Order_Comments'
                ],
                'dataScope' => 'myOrderComments.myCheckout[orderComments]',
                'label' => "Comments",
                'provider' => 'checkoutProvider',
                'visible' => true,
                'sortOrder' => 80,
                'id' => 'myCheckout[orderComments]'
            ];
        }
        return $jsLayout;
    }
}
