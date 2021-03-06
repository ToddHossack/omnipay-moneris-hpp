<?php
namespace Omnipay\Moneris\Message;

/**
 * Moneris Complete Purchase Response
 */
class CompletePurchaseResponse extends AbstractResponse
{

    public function isSuccessful()
    {
        return (
            (isset($this->data['message']) && strpos($this->data['message'],'APPROVED') !== false) 
            || 
            (isset($this->data['ISSCONF']) && isset($this->data['bank_approval_code']) && $this->data['bank_approval_code'] != '000000')
        );
    }

    /**
     * Requires "Enhanced Cancel" to be configured
     * @return boolean
     */
    public function isCancelled()
    {
        return (isset($this->data['response_code']) && intval($this->data['response_data']) === 914);
    }
    
    public function getTransactionReference()
    {
        return isset($this->data['bank_transaction_id']) ? $this->data['bank_transaction_id'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['message']) ? $this->data['message'] : null;
    }
}
