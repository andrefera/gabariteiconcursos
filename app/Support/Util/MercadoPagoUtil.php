<?php

namespace App\Support\Util;

use App\Models\Enums\PaymentStatus;

readonly class MercadoPagoUtil
{
    public static function convertStatusPayment(string $status, string $statusDetail): string
    {
        //https://www.mercadopago.com.br/developers/en/reference/payments/_payments_id/put
        //It is the current state of payment. It can be two following types.
        //pending: The user has not concluded the payment process (for example, to generate a payment by ticket, this payment will be concluded at the moment in which the user makes the non-corresponding payment selected);
        //approved: The payment was approved and credited;
        //authorized: The payment was authorized, but still was not captured;
        //in_process: The payment is in analysis;
        //in_mediation: The user started a dispute;
        //rejected: The payment was rejected. (The user can try the payment again);
        //cancelled: Either the payment was canceled by one of the parties or the payment expired;
        //refunded: The payment was returned to the user;
        //charged_back: A chargeback was placed on the buyer's credit card.

        return match ($status) {
            "approved" => match ($statusDetail) {
                "partially_refunded", "refunded" => PaymentStatus::REFUNDED->value,
                default => PaymentStatus::PAID->value,
            },
            "rejected" => PaymentStatus::REJECTED->value,
            "cancelled", "in_mediation", "refunded", "charged_back" => PaymentStatus::REFUNDED->value,
            default => PaymentStatus::WAITING_PAYMENT->value,
        };
    }

    public static function getMessage(string $status, string $statusDetail): string
    {
        return match ($status) {
            "pending" => "O usuário não concluiu o processo de pagamento;",
            "approved" => "O pagamento foi aprovado e creditado;",
            "authorized" => "O pagamento foi autorizado, mas ainda não foi capturado;",
            "in_process" => "O pagamento está em análise;",
            "in_mediation" => "O usuário iniciou uma disputa;",
            "rejected" => match ($statusDetail) {
                "Accredited" => "Pagamento creditado.",
                "pending_contingency" => "O pagamento está sendo processado.",
                "pending_review_manual" => "o pagamento está em análise para determinar sua aprovação ou rejeição.",
                "cc_rejected_bad_filled_date" => "Data de vencimento incorreta.",
                "cc_rejected_bad_filled_other" => "Detalhes do cartão incorretos.",
                "cc_rejected_bad_filled_security_code" => "CVV incorreto.",
                "cc_rejected_blacklist" => "O cartão está em uma lista negra por roubo/reclamações/fraude.",
                "cc_rejected_call_for_authorize" => "O meio de pagamento requer autorização prévia do valor da operação.",
                "cc_rejected_card_disabled" => "O cartão está inativo.",
                "cc_rejected_duplicated_payment" => "Transação duplicada.",
                "cc_rejected_high_risk" => "Rejeição por Prevenção de Fraude.",
                "cc_rejected_insufficient_amount" => "Valor insuficiente.",
                "cc_rejected_invalid_installments" => "Número inválido de parcelas.",
                "cc_rejected_max_attempts" => "Excedido o número máximo de tentativas.",
                "cc_rejected_other_reason" => "O banco emissor do cartão recusou o pagamento.",
                default => "O pagamento foi rejeitado. (O usuário pode tentar o pagamento novamente);",
            },
            "cancelled" => "O pagamento foi cancelado por uma das partes ou o pagamento expirou;",
            "refunded" => "O pagamento foi devolvido ao usuário;",
            "charged_back" => "Um chargeback foi aplicado no cartão de crédito do comprador.",
            default => "",
        };
    }
}