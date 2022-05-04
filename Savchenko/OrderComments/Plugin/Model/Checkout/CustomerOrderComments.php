<?php

declare(strict_types=1);

namespace Savchenko\OrderComments\Plugin\Model\Checkout;
use Closure;
use Magento\Checkout\Model\PaymentInformationManagement;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class CustomerOrderComments
 */
class CustomerOrderComments
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param PaymentInformationManagement $subject
     * @param Closure $proceed
     * @param $cartId
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     */
    public function aroundSavePaymentInformationAndPlaceOrder(
        PaymentInformationManagement $subject,
        Closure $proceed,
        $cartId,
        PaymentInterface $paymentMethod,
        AddressInterface $billingAddress = null
    ) {
        $orderId = $proceed($cartId, $paymentMethod, $billingAddress);
        if ($orderId) {
            $order = $this->orderRepository->get($orderId);
            $orderComments = $paymentMethod->getExtensionAttributes()->getOrderComments();
            $order->setOrderComments($orderComments);
            $this->orderRepository->save($order);
        }
    }
}
