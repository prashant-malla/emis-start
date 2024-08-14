<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use App\Models\Batch;

class BatchController extends Controller
{
    protected $title = 'Batch';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['batches'] = Batch::latest('id')->get();

        $data['title'] = $this->title;

        return view('pages.academics.batch.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['title'] = $this->title;

        return view('pages.academics.batch.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBatchRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBatchRequest $request)
    {
        $data = $request->validated();

        Batch::create($data);

        return redirect()->route('batch.index')->withSuccess('Batch created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\View\View
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\View\View
     */
    public function edit(Batch $batch)
    {
        $data['title'] = $this->title;
        $data['batch'] = $batch;

        return view('pages.academics.batch.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBatchRequest $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBatchRequest $request, Batch $batch)
    {
        $data = $request->validated();

        $batch->update($data);

        return redirect()->route('batch.index')->withSuccess('Batch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();

        return redirect()->route('batch.index')->withSuccess('Batch deleted successfully');
    }
}
