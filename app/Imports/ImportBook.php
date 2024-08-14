<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\BookNumber;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportBook implements ToCollection, WithStartRow, WithMultipleSheets, SkipsEmptyRows
{
    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $idx => $row) {
            $lineNumber = $idx + $this->startRow();

            try {
                $this->validateRow($row, $lineNumber);
                $row[9] = $this->convertDate($row->get(9));

                $book = Book::updateOrCreate(['isbn_number'=>$row->get(2)],[
                    'title' => $row->get(0),
                    'book_number' => $row->get(1) ?? 'NA',
                    'isbn_number' => $row->get(2) ?? 'NA',
                    'publisher' => $row->get(3) ?? 'NA',
                    'author' => $row->get(4) ?? 'NA',
                    'subject' => $row->get(5) ?? 'NA',
                    'rack_number' => $row->get(6) ?? 'NA',
                    'quantity' => $row->get(7) ?? 'NA',
                    'book_price' => $row->get(8) ?? 'NA',
                    'post_date' => $row->get(9),
                    'book_type' => $row->get(10) ?? null,
                    'book_edition' => $row->get(11) ?? null,
                    'description' => $row->get(12) ?? null,
                ]);
                $this->addBookNumbers($book, $row->get(7));
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage() . ' at line ' . $lineNumber);
            }
        }
    }

    private function validateRow(Collection $row): void
    {
        if (empty($row->get(0))) {
            throw new \Exception("Title not found");
        }

        if (empty($row->get(2))) {
            throw new \Exception("ISBN number not found");
        }

        if (empty($row->get(9))) {
            throw new \Exception("Purchase date not found");
        }
    }

    private function convertDate($value): string
    {
        if (is_integer($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        if (strpos($value, '/') !== false) {
            $dobItems = explode('/', $value);
            if (strlen($dobItems[0]) === 4) {
                return implode('-', $dobItems);
            } else {
                return "{$dobItems[2]}-{$dobItems[0]}-{$dobItems[1]}";
            }
        }

        return $value;
    }

    private function addBookNumbers(Book $book, $quantity)
    {
        if (intval($quantity) > 0) {
            $existingBookNumbers = BookNumber::where('book_id', $book->id)->pluck('book_number')->toArray();
            for ($i = 1; $i <= intval($quantity); $i++) {
                $newBookNumber = $book->book_number.'-' + $i;
                                
                if (!in_array($newBookNumber, $existingBookNumbers)) {
                    BookNumber::create([
                        'book_id' => $book->id,
                        'book_number' => $newBookNumber,
                    ]);
                }
            }
        }
    }
    
}
