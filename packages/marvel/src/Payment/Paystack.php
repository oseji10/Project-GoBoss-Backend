<?php

namespace Marvel\Payments;

use Exception;
use Illuminate\Support\Facades\Http;
use Marvel\Exceptions\MarvelException;
use Marvel\Payments\PaymentInterface;
use Marvel\Payments\Base;
use Unicodeveloper\Paystack\Facades\Paystack as PaystackFacade;
use Illuminate\Support\Facades\Log;
// use Paystack\Paystack;


class Paystack extends Base implements PaymentInterface
{
//   public function getIntent($data)
public function getIntent(array $data): array
{
    try {
        extract($data);
        $authorizationData = PaystackFacade::getAuthorizationUrl();
        $redirectUrl = $authorizationData['url'];
        $isRedirect = true;

        return [
            'redirect_url' => $redirectUrl,
            'is_redirect' => $isRedirect,
        ];
    } catch (Exception $e) {
        throw new MarvelException(SOMETHING_WENT_WRONG_WITH_PAYMENT);
    }
}

//   public function verify($paymentId)
//   public function verify(array $paymentId): array
public function verify(string $paymentId): mixed
  {
    try {
      $response = Http::withHeaders([
        "Authorization" => "Bearer " . config('shop.paystack.secret_key'),
        "Cache-Control" => "no-cache",
      ])->get(config('shop.paystack.payment_url') . '/verify' . '/' . $paymentId);

      return $response->successful();
    } catch (Exception $e) {
      throw new MarvelException(SOMETHING_WENT_WRONG_WITH_PAYMENT);
    }
  }
}
