<?php

namespace App\Services;

use App\Exports\LibraryBookExport;
use App\Imports\ImportBook;
use App\Models\Book;
use App\Models\BookNumber;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BookService
{
    // public function generateBookNumbers(int $startNumber, int $count)
    // {
    //     return range($startNumber, $startNumber + $count - 1);
    // }

    public function createBookWithNumbers(array $data)
    {
        $book = Book::create($data);

        $quantity = $book->quantity ?? 0;
        $bookNumber = $book->book_number ?? 0;

        if ($quantity > 0 && $bookNumber > 0) {
            $bookNumbers = [];
            for ($i = 0; $i < $quantity; $i++) {
                $bookNumbers[] = [
                    'book_id' => $book->id,
                    'book_number' => $bookNumber . "-". $i+1,
                    'author'=>$data['author'] ?? null,
                    'publisher'=>$data['publisher'] ?? null,
                    'book_edition'=>$data['book_edition'] ?? null,
                ];
            }
            BookNumber::insert($bookNumbers);
        }

        if (isset($data['document'])) {
            $book->addMedia($data['document'])->toMediaCollection();
        }

        if (isset($data['cover_image'])) {
            $book->addMedia($data['cover_image'])->toMediaCollection('image');
        }
    }

    public function updateBookWithNumbers(Book $book, array $data)
    {
        $newQuantity = $data['quantity'] ?? $book->quantity;
        $newBookNumber = $data['book_number'] ?? $book->book_number;

        if ($newQuantity != $book->quantity || $newBookNumber != $book->book_number) {
            $book->bookNumbers()->delete();

            if ($newQuantity > 0 && $newBookNumber > 0) {
                $bookNumbers = [];
                for ($i = 0; $i < $newQuantity; $i++) {
                    $bookNumbers[] = [
                        'book_id' => $book->id,
                        'book_number' => $newBookNumber ."-" . $i+1,
                        'author'=>$data['author'] ?? null,
                        'publisher'=>$data['publisher'] ?? null,
                        'book_edition'=>$data['book_edition'] ?? null,
                    ];
                }
                BookNumber::insert($bookNumbers);
            }
        }

        $book->update($data);

        // delete document
        if (isset($data['document']) || (isset($data['delete_document']) && $data['delete_document'])) {
            $book->clearMediaCollection();
        }

        if (isset($data['document'])) {
            $book->addMedia($data['document'])->toMediaCollection();
        }

        // delete cover image
        if (isset($data['cover_image']) || (isset($data['delete_cover_image']) && $data['delete_cover_image'])) {
            $book->clearMediaCollection('image');
        }

        if (isset($data['cover_image'])) {
            $book->addMedia($data['cover_image'])->toMediaCollection('image');
        }
    }

    public function importBooks(UploadedFile $file)
    {
        DB::beginTransaction();

        try {
            Excel::import(new ImportBook(), $file);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
