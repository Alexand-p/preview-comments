<?php

declare(strict_types=1);

namespace Savchenko\OrderComments\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 */
class Data extends AbstractHelper
{
    const ORDER_COMMENTS_ENABLED = 'checkout/ordercomments/enabled';
    /**
     * ScopeConfig
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param Context $context
     * @param ScopeConfigInterface $scopeInterface
     */
    public function __construct(
        Context              $context,
        ScopeConfigInterface $scopeInterface
    )
    {
        parent::__construct($context);
        $this->scopeConfig = $scopeInterface;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return (bool)$this->getConfigValue(self::ORDER_COMMENTS_ENABLED);
    }


}
