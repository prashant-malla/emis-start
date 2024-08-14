<div class="modal fade" id="fineModal" tabindex="-1" aria-labelledby="fineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Additional Fines Applied</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fineForm" class="validate-basic" action="{{route('student_fine.save', $student)}}"
                    method="POST">
                    @csrf
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <td width="50"></td>
                                <td>
                                    <input type="text" class="form-control" name="title" placeholder="Fine Title"
                                        required>
                                </td>
                                <td width="120" class="text-right">
                                    <input type="number" class="form-control" name="amount" min="0" required>
                                </td>
                                <td width="50">
                                    <button id="fine-submit-button" type="submit" class="btn btn-success">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studentFines as $key => $fine)
                            <tr data-fine-amount="{{$fine->amount}}">
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input fine-check"
                                            id="customFineCheck{{$key}}" name="fine_id[]" value="{{$fine->id}}" checked>
                                        <label class="custom-control-label" for="customFineCheck{{$key}}"></label>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{$fine->title}}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right" value="{{$fine->amount}}"
                                        readonly>
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-right">Total Fine</th>
                                <td>
                                    <input id="totalFineCalculated" type="text" class="form-control text-right fw-bold"
                                        value="{{convertToMoney($studentFines->sum('amount'))}}" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>