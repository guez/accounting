<?php

namespace Guez\Accounting\Services;

use Guez\Accounting\Exceptions\DebitAndCreditNotEqualsException;
use Guez\Accounting\Exceptions\ValueNotValidException;
use Guez\Accounting\Models\AccountingEntry;
use Guez\Accounting\Models\AccountingEntryDetail;
use Illuminate\Support\Facades\DB;

class AccountingService
{
  public static function createEntry(int $merchantId, string $entryDescription, array $entryDetails, $date = null): ?AccountingEntry
  {
    if ($entryDescription or empty($entryDetails)) {
      return null;
    }

    $debit = 0;
    $credit = 0;

    foreach ($entryDetails as $detail) {
      if (!isset($detail['accountId']) or !isset($detail['value']) or !isset($detail['type'])) {
        throw new ValueNotValidException("Not valid");
      }

      if ($detail['type'] == "DEBIT") {
        $debit += (float)$detail['value'];
      } else if ($detail['type'] == "CREDIT") {
        $credit += (float)$detail['value'];
      } else {
        throw new ValueNotValidException("Not valid.");
      }
    }

    if ($debit !== $credit) {
      throw new DebitAndCreditNotEqualsException("Debit and credit not equals.");
    }

    DB::beginTransaction();

    $entry = new AccountingEntry();
    $entry->date = $date ?? now();
    $entry->description = $entryDescription;
    $entry->merchantId = $merchantId;
    $entry->save();

    foreach ($entryDetails as $detail) {
      $entryDetail = new AccountingEntryDetail();
      $entryDetail->merchantId = $merchantId;
      $entryDetail->entryId = $entry->id;
      $entryDetail->accountId = $detail['accountId'];

      if ($detail['type'] == "DEBIT") {
        $entryDetail->debit = $detail['value'];
      } else {
        $entryDetail->credit = $detail['value'];
      }

      $entryDetail->save();
    }

    DB::commit();

    $entry->load('details');

    return $entry;
  }

  public static function verifyEntry(AccountingEntry $entry)
  {
    $debit = $entry->details()
      ->sum('debit');

    $credit = $entry->details()
      ->sum('credit');

    if ($debit !== $credit) {
      return false;
    }

    return true;
  }
}
