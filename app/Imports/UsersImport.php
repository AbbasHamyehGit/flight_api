<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Contracts\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Assuming the first row contains column headers
            if ($row->first() !== 'Name') {
                User::updateOrCreate(
                    ['email' => $row[1]], // Assuming email is in the second column
                    ['name' => $row[0], 'password' => bcrypt('password')] // Assuming name is in the first column
                );
            }
        }
    }
}
