<tr>

  <td>
    <div class="form-group mb-0" style="max-width: 300px">
      <select name="ledger_account_id[]" class="form-control select" required>
        <option value="">Select Account</option>
        @foreach($ledgerAccounts as $account)
        <option value="{{$account->id}}" data-balance="{{$account->balance}}" @selected($account->id ===
          @$rowData->ledger_account_id)>
          {{$account->account_name}} [{{$account->accountCategory->name}} - {{$account->accountCategory->type}}]
        </option>
        @endforeach
      </select>
    </div>
  </td>

  <td>
    <input type="number" class="form-control bg-light balance text-right" placeholder="0.00" value="{{@$rowData->balance}}"
      readonly>
  </td>

  <td>
    <input type="number" class="form-control text-right" name="debit_amount[]" placeholder="0.00" step="0.01" min="0"
      value="{{@$rowData->debit_amount}}">
    <div class="text-muted small remaining remaining-debit"></div>
  </td>

  <td>
    <input type="number" class="form-control text-right" name="credit_amount[]" placeholder="0.00" step="0.01" min="0"
      value="{{@$rowData->credit_amount}}">
    <div class="text-muted small remaining remaining-credit"></div>
  </td>

  <td>
    <input type="text" class="form-control" name="remark[]" placeholder="Enter remark" value="{{@$rowData->remark}}">
  </td>

  <td class="action-td">
    <button type="button" class="btn btn-sm btn-danger" onclick="removeRows(this)">
      <i class="la la-trash-o"></i>
    </button>
  </td>

</tr>