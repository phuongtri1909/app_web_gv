<?php 

namespace App\Imports;

use App\Models\Competition;
use App\Models\Quiz;
use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class CompetitionsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $currentCompetition = null;
        $currentQuiz = null;

        foreach ($rows as $row) {
            
            if (!empty($row['cuoc-thi'])) {
                $currentCompetition = Competition::create([
                    'title' => $row['cuoc-thi'],
                    'start_date' => \Carbon\Carbon::createFromFormat('d/m/Y H:i', $row['c']),
                    'end_date' => \Carbon\Carbon::createFromFormat('d/m/Y H:i', $row['d']),
                    'status' => $row['e'],
                    'time_limit' => $row['g'],
                ]);
            }

           
            if (!empty($row['bo-cau-hoi'])) {
                $currentQuiz = Quiz::create([
                    'competition_id' => $currentCompetition->id,
                    'title' => $row['bo-cau-hoi'],
                    'status' => $row['e'],
                    'quantity_question' => $row['f'], // Assuming column F is question count
                ]);
            }

            // Add questions and answers
            if (!empty($row['cau-hoi'])) {
                $answers = [];
                for ($i = 3; $i <= 7; $i++) { // Columns C to G contain answers
                    if (!empty($row[chr(96 + $i)])) { // Dynamic column access (C = chr(99))
                        $answers[] = $row[chr(96 + $i)];
                    }
                }

                Question::create([
                    'quiz_id' => $currentQuiz->id,
                    'question_name' => $row['cau-hoi'],
                    'answer_true' => $row['dap-an'], // Assuming column H contains the correct answer
                    'answer' => json_encode($answers),
                ]);
            }
        }
    }
}
