<?php

/**
 * Class CronApp
 */
class CronApp
{
    /**
     * @var self
     */
    private static $appInstance;

    /**
     * Initiate point of application
     */
    public static function run()
    {
         self::getInstane()->processCustomers();
    }

    /**
     * @return CronApp
     */
    private static function getInstane()
    {
        if (!isset(self::$appInstance)) {
            self::$appInstance = new self;
        }
        return self::$appInstance;
    }

    /**
     * CronApp constructor.
     */
    private function __construct() {}

    /**
     * Process customers according to
     * different strategies
     */
    private function processCustomers()
    {
        foreach ($this->getCustomers() as $customer) {
            //If the customer is newly registered, one day back in time
            if ( $customer->createdAt > (new DateTime())->modify('-1 day') ) {
                try {
                    $mail = new Mail($customer);
                    // We include template
                    $mail->setTemplate(new WelcomeTemplate);
                    //Send mail
                    $mail->send();
                } catch (\Exception $exception) {
                    Log($exception->getMessage());
                }
            }
            // We send mail if customer hasn't put an order
            $send = true;
            //loop through list of orders to see if customer don't exist in that list
            foreach ($this->getOrders() as $order ) {
                // Email exists in order list
                if ($customer->email == $order->customerEmail) {
                    //We don't send email to that customer
                    $send = false;
                }
            }
            if ($send) {
                try {
                    $mail = new Mail($customer);
                    // We include template
                    $mail->setTemplate(new BackTemplate);
                    $mail->send();
                } catch (\Exception $exception) {
                    Log($exception->getMessage());
                }
            }
        }
    }

    /**
     * @return Order[]
     */
    private function getOrders()
    {
        return DataLayer::ListOrders();
    }

    /**
     * @return Customer[]
     */
    private function getCustomers()
    {
        return DataLayer::ListCustomers();
    }
}