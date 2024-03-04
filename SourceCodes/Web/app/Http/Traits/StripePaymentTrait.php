<?php

namespace app\Http\Traits;

trait StripePaymentTrait
{
    public function successPaymentResponse($charge)
    {
        $payment_response = [
            'id' => $charge->id,
            'object' => $charge->object,
            'amount' => $charge->amount/100,
            'amount_captured' => $charge->amount_captured/100,
            'amount_refunded' => $charge->amount_refunded/100,
            'application' => $charge->application,
            'application_fee' => $charge->application_fee,
            'application_fee_amount' => $charge->application_fee_amount,
            'balance_transaction' => $charge->balance_transaction,
            'billing_details' => $charge->billing_details,
            'calculated_statement_descriptor' => $charge->calculated_statement_descriptor,
            'captured' => $charge->captured,
            'created' => $charge->created,
            'currency' => $charge->currency,
            'customer' => $charge->customer,
            'description' => $charge->description,
            'destination' => $charge->destination,
            'dispute' => $charge->dispute,
            'disputed' => $charge->disputed,
            'failure_balance_transaction' => $charge->failure_balance_transaction,
            'failure_code' => $charge->failure_code,
            'failure_message' => $charge->failure_message,
            'fraud_details' => $charge->fraud_details,
            'invoice' => $charge->invoice,
            'livemode' => $charge->livemode,
            'metadata' => $charge->metadata,
            'on_behalf_of' => $charge->on_behalf_of,
            'order' => $charge->order,
            'outcome' => $charge->outcome,
            'paid' => $charge->paid,
            'payment_intent' => $charge->payment_intent,
            'payment_method' => $charge->payment_method,
            'payment_method_details' => $charge->payment_method_details,
            'receipt_email' => $charge->receipt_email,
            'receipt_number' => $charge->receipt_number,
            'receipt_url' => $charge->receipt_url,
            'refunded' => $charge->refunded,
            'refunds' => $charge->refunds,
            'review' => $charge->review,
            'shipping' => $charge->shipping,
            'source' => $charge->source,
            'source_transfer' => $charge->source_transfer,
            'statement_descriptor' => $charge->statement_descriptor,
            'statement_descriptor_suffix' => $charge->statement_descriptor_suffix,
            'status' => $charge->status,
            'transfer_data' => $charge->transfer_data,
            'transfer_group' => $charge->transfer_group,
        ];
        return $payment_response;
    }

    public function failedPaymentResponse($e)
    {
        $payment_response = [
            'status' => $e->getHttpStatus(),
            'type' => $e->getError()->type,
            'decline_code' => $e->getError()->decline_code,
            'error_code' => $e->getError()->code,
            'param' => $e->getError()->param,
            'message' => $e->getError()->message
        ];
        return $payment_response;
    }
}
